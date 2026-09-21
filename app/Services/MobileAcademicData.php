<?php

namespace App\Services;

use App\Models\{AcademicYear, Grade, GuardianChild, SchoolClass, Student};
use Illuminate\Support\Collection;

class MobileAcademicData
{
    public function studentSummary(Student $student): array
    {
        $student->loadMissing('info.gradeLevel', 'info.academicYear', 'info.schoolClass.adviser');
        $info = $student->info;
        return [
            'id' => $student->id,
            'student_number' => $student->student_number,
            'name' => $info?->name ?? $student->username,
            'email' => $student->portalAccount?->email ?? $student->email,
            'contact' => $student->portalAccount?->contact ?? $info?->contact,
            'address' => $student->portalAccount?->address ?? $info?->address,
            'school_year' => $info?->academicYear ? ['id' => $info->academicYear->id, 'name' => $info->academicYear->name] : null,
            'grade_level' => $info?->gradeLevel?->name,
            'class' => $info?->schoolClass?->name,
            'class_adviser' => $info?->schoolClass?->adviser?->name,
        ];
    }

    public function currentSubjects(Student $student): array
    {
        $info = $student->info;
        if (! $info?->admited) return [];
        $class = SchoolClass::whereKey($info->class_id)->where('acady_id', $info->acady_id)
            ->where('grlvl_id', $info->grlvl_id)
            ->with('classSubjects.subject', 'classSubjects.teacher', 'classSchedules.room')->first();
        if (! $class) return [];
        return $class->classSubjects->filter(fn ($load) => $load->subject)->map(function ($load) use ($class) {
            return [
                'id' => $load->sub_id,
                'name' => $load->subject->name,
                'teacher' => $load->teacher?->name,
                'schedules' => $class->classSchedules->where('subject_id', $load->sub_id)->map(fn ($schedule) => [
                    'day' => $schedule->day,
                    'time_from' => $schedule->time_from,
                    'time_to' => $schedule->time_to,
                    'room' => $schedule->room?->name,
                ])->values()->all(),
            ];
        })->values()->all();
    }

    public function gradeRecord(Student $student, ?int $yearId = null): array
    {
        $approved = Grade::recorded()->approved()->where('student_id', $student->id);
        $yearIds = (clone $approved)->distinct()->pluck('academic_year_id');
        if ($student->info?->acady_id) $yearIds->push($student->info->acady_id);
        $years = AcademicYear::whereIn('id', $yearIds->filter()->unique())->orderByDesc('id')->get();
        $selected = $yearId ?: (int) ((clone $approved)->max('academic_year_id') ?: $student->info?->acady_id ?: $years->first()?->id);
        abort_if($selected && ! $years->contains('id', $selected), 404, 'School year is not available for this student.');
        $grades = (clone $approved)->where('academic_year_id', $selected)->orderBy('class_name')->orderBy('subject_name')->get();
        $classes = $this->classesForGrades($student, $selected, $grades);
        return [
            'student' => $this->studentSummary($student),
            'years' => $years->map(fn ($year) => ['id' => $year->id, 'name' => $year->name])->values()->all(),
            'selected_school_year_id' => $selected ?: null,
            'classes' => $classes,
        ];
    }

    public function guardianChildren(int $guardianId): array
    {
        $links = GuardianChild::where('guardian_id', $guardianId)->where('status', 'VERIFIED')->get()->keyBy('student_id');
        return Student::with('portalAccount', 'info.gradeLevel', 'info.academicYear', 'info.schoolClass')
            ->whereIn('id', $links->keys())->orderBy('username')->get()->map(function ($student) use ($links) {
                return $this->studentSummary($student) + ['relationship' => $links[$student->id]->relationship];
            })->values()->all();
    }

    private function classesForGrades(Student $student, int $yearId, Collection $grades): array
    {
        $classIds = $grades->pluck('class_id')->filter()->unique();
        if ($student->info?->acady_id == $yearId && $student->info?->class_id) $classIds->push($student->info->class_id);
        $classes = SchoolClass::with('gradeLevel', 'academicYear', 'adviser', 'classSubjects.subject', 'classSubjects.teacher')
            ->whereIn('id', $classIds->unique())->where('acady_id', $yearId)->get();
        return $classes->map(function ($class) use ($grades) {
            $classGrades = $grades->where('class_id', $class->id);
            $rows = collect();
            foreach ($class->classSubjects->filter(fn ($load) => $load->subject) as $load) {
                $rows->put($load->sub_id, ['id' => $load->sub_id, 'name' => $load->subject->name, 'teacher' => $load->teacher?->name, 'grades' => []]);
            }
            foreach ($classGrades as $grade) {
                $row = $rows->get($grade->subject_id, ['id' => $grade->subject_id, 'name' => $grade->subject_name, 'teacher' => $grade->teacher_name, 'grades' => []]);
                $row['grades']['q'.$grade->quarter] = (float) $grade->grade;
                $rows->put($grade->subject_id, $row);
            }
            return [
                'id' => $class->id, 'name' => $class->name,
                'grade_level' => $class->gradeLevel?->name,
                'school_year' => $class->academicYear?->name,
                'adviser' => $class->adviser?->name,
                // A subject's quarter grades are always a JSON object. Casting here
                // prevents PHP's empty array from changing the API type from {} to [].
                'subjects' => $rows->values()->map(function ($row) {
                    $row['grades'] = (object) $row['grades'];
                    return $row;
                })->all(),
            ];
        })->values()->all();
    }
}
