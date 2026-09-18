@extends('layouts.app')
@section('title', 'Teacher Load')
@section('content')
<main class="p-4 space-y-5">
    <h1 class="text-3xl font-black">Teacher Load</h1>
    @if(session('success'))<p class="rounded bg-green-50 p-3 text-green-800">{{ session('success') }}</p>@endif
    @if($errors->any())<p class="rounded bg-red-50 p-3 text-red-800">{{ $errors->first() }}</p>@endif
    <form method="POST" action="{{ route('academic.schedule-load.teacher-load.store') }}" class="flex flex-wrap items-end gap-3 rounded border bg-white p-4">
        @csrf
        <label class="grid gap-1">Teacher
            <select name="teacher_id" required class="rounded border p-2"><option value="">Select teacher</option>@foreach($teachers as $teacher)<option value="{{ $teacher->id }}" @selected(old('teacher_id') == $teacher->id)>{{ $teacher->name }}</option>@endforeach</select>
        </label>
        <label class="grid gap-1">Class and school year
            <select name="class_id" required class="rounded border p-2"><option value="">Select class</option>@foreach($classes as $class)<option value="{{ $class->id }}" @selected(old('class_id') == $class->id)>{{ $class->gradeLevel?->name }} {{ $class->name }} — {{ $class->academicYear?->name }}</option>@endforeach</select>
        </label>
        <label class="grid gap-1">Subject
            <select name="sub_id" required class="rounded border p-2"><option value="">Select subject</option>@foreach($subjects as $subject)<option value="{{ $subject->id }}" @selected(old('sub_id') == $subject->id)>{{ $subject->name }}</option>@endforeach</select>
        </label>
        <button class="rounded bg-blue-700 px-4 py-2 font-bold text-white">Assign</button>
    </form>
    <form method="GET" action="{{ route('academic.schedule-load.teacher-load') }}"><input name="search" value="{{ $search }}" placeholder="Search teacher, subject, or class" class="w-full max-w-md rounded border p-2"></form>
    <div class="overflow-x-auto rounded border bg-white"><table class="w-full text-left text-sm"><thead class="bg-blue-700 text-white"><tr><th class="p-3">Teacher</th><th class="p-3">Subject</th><th class="p-3">Class / Section</th><th class="p-3">School Year</th><th class="p-3">Schedule</th><th class="p-3">Students</th><th class="p-3">Actions</th></tr></thead><tbody>
    @forelse($loads as $load)<tr class="border-t"><td class="p-3">{{ $load->teacher->name }}</td><td class="p-3">{{ $load->subject->name }}</td><td class="p-3">{{ $load->schoolClass->gradeLevel?->name }} {{ $load->schoolClass->name }}</td><td class="p-3">{{ $load->schoolClass->academicYear?->name }}</td><td class="p-3">@forelse($load->schoolClass->classSchedules->where('subject_id',$load->sub_id) as $schedule)<div>{{ $schedule->day }} {{ \Carbon\Carbon::parse($schedule->time_from)->format('g:i A') }}–{{ \Carbon\Carbon::parse($schedule->time_to)->format('g:i A') }}{{ $schedule->room ? ' · '.$schedule->room->name : '' }}</div>@empty Not scheduled @endforelse</td><td class="p-3">{{ \App\Models\StudentInfo::where('class_id',$load->class_id)->where('acady_id',$load->schoolClass->acady_id)->where('grlvl_id',$load->schoolClass->grlvl_id)->where('admited',1)->whereHas('student')->distinct()->count('student_id') }}</td><td class="p-3"><div class="flex gap-2"><form method="POST" action="{{ route('academic.schedule-load.teacher-load.update',$load) }}">@csrf @method('PUT')<select name="teacher_id" aria-label="Reassign teacher" class="rounded border p-1">@foreach($teachers as $teacher)<option value="{{ $teacher->id }}" @selected($teacher->id === $load->teacher_id)>{{ $teacher->name }}</option>@endforeach</select><button class="rounded border px-2 py-1">Save</button></form><form method="POST" action="{{ route('academic.schedule-load.teacher-load.destroy',$load) }}">@csrf @method('DELETE')<button class="rounded border border-red-500 px-2 py-1 text-red-700">Remove</button></form></div></td></tr>
    @empty<tr><td colspan="7" class="p-6 text-center">No teaching loads assigned.</td></tr>@endforelse
    </tbody></table></div>
    {{ $loads->links() }}
    <h2 class="text-xl font-bold">Unassigned class subjects ({{ $unassigned->total() }})</h2>
    <p>These class subjects have no confirmed teacher assignment. Select a teacher for each load.</p>
    <div class="overflow-x-auto rounded border bg-white"><table class="w-full text-left text-sm"><thead class="bg-slate-700 text-white"><tr><th class="p-3">Class</th><th class="p-3">School Year</th><th class="p-3">Subject</th><th class="p-3">Assign teacher</th></tr></thead><tbody>
    @forelse($unassigned as $load)<tr class="border-t"><td class="p-3">{{ $load->schoolClass->gradeLevel?->name }} {{ $load->schoolClass->name }}</td><td class="p-3">{{ $load->schoolClass->academicYear?->name }}</td><td class="p-3">{{ $load->subject->name }}</td><td class="p-3"><form method="POST" action="{{ route('academic.schedule-load.teacher-load.update',$load) }}">@csrf @method('PUT')<select name="teacher_id" required class="rounded border p-1"><option value="">Select teacher</option>@foreach($teachers as $teacher)<option value="{{ $teacher->id }}">{{ $teacher->name }}</option>@endforeach</select><button class="rounded border px-2 py-1">Assign</button></form></td></tr>
    @empty<tr><td colspan="4" class="p-6 text-center">All class subjects are assigned.</td></tr>@endforelse
    </tbody></table></div>
    {{ $unassigned->links() }}
</main>
@endsection
