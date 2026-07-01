<?php

namespace Database\Seeders;

use App\Models\ClassSchedule;
use App\Models\Room;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ClassScheduleSeeder extends Seeder
{
    /**
     * Seed rooms and class schedules.
     */
    public function run(): void
    {
        $rooms = $this->seedRooms();

        if (! Schema::hasTable('classsched') || $rooms->isEmpty() || ! Schema::hasTable('class') || ! Schema::hasTable('subject')) {
            return;
        }

        $classes = SchoolClass::query()->orderBy('id')->get()->values();
        $subjects = Subject::query()->orderBy('id')->get()->values();
        if ($classes->isEmpty() || $subjects->isEmpty()) {
            return;
        }

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = [
            ['07:30', '08:30'],
            ['08:30', '09:30'],
            ['10:00', '11:00'],
            ['11:00', '12:00'],
            ['13:00', '14:00'],
        ];

        foreach ($classes as $classIndex => $class) {
            foreach ($days as $dayIndex => $day) {
                $subject = $subjects->get(($classIndex * 5 + $dayIndex) % $subjects->count());
                $room = $rooms->get(($classIndex + $dayIndex) % $rooms->count());
                $slot = $timeSlots[$dayIndex % count($timeSlots)];

                ClassSchedule::updateOrCreate([
                    'class_id' => $class->id,
                    'subject_id' => $subject->id,
                    'day' => $day,
                ], [
                    'room_id' => $room->id,
                    'time_from' => $slot[0],
                    'time_to' => $slot[1],
                ]);
            }
        }
    }

    private function seedRooms()
    {
        if (! Schema::hasTable('rooms')) {
            return collect();
        }

        foreach (['Room 101', 'Room 102', 'Room 201', 'Science Lab', 'Computer Lab'] as $name) {
            Room::updateOrCreate(['name' => $name]);
        }

        return Room::query()->orderBy('id')->get()->values();
    }
}
