<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'absensi@datanet.net'],
            [
                'name' => 'Perangkat Absensi',
                'password' => 'absensi-standby',
                'role' => 'attendance',
            ]
        );
    }
}
