<?php

namespace Database\Seeders;

use App\Models\Guardian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class GuardianSeeder extends Seeder
{
    /**
     * Seed parent and guardian accounts.
     */
    public function run(): void
    {
        if (! Schema::hasTable('guardians')) {
            return;
        }

        foreach ($this->guardians() as $guardian) {
            Guardian::updateOrCreate(
                ['username' => $guardian['username']],
                [
                    'email' => $guardian['email'],
                    'name' => $guardian['name'],
                    'contact' => $guardian['contact'],
                    'address' => $guardian['address'],
                    'password' => Hash::make('parent123'),
                ]
            );
        }
    }

    private function guardians(): array
    {
        $lastNames = [
            'Dela Cruz', 'Santos', 'Reyes', 'Garcia', 'Mendoza', 'Lopez',
            'Flores', 'Aquino', 'Navarro', 'Ramos', 'Torres', 'Castro',
            'Villanueva', 'Bautista', 'Cruz', 'Diaz', 'Morales', 'Rivera',
            'Gonzales', 'Padilla', 'Salazar', 'Domingo', 'Mercado', 'Pascual',
            'Valdez', 'Aguilar', 'Rosales', 'Fernandez', 'Alvarez', 'Gutierrez',
        ];

        return collect($lastNames)->map(fn (string $lastName, int $index) => [
            'username' => 'parent'.str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
            'email' => 'parent'.str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT).'@example.com',
            'name' => 'Mr./Ms. '.$lastName,
            'contact' => '09'.str_pad((string) (170000000 + $index), 9, '0', STR_PAD_LEFT),
            'address' => 'Barangay '.(($index % 10) + 1).', Cauayan City, Isabela',
        ])->all();
    }
}
