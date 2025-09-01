<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['role' => 'Super Admin'],
            ['role' => 'Admin'],
            ['role' => 'Kepala Sekolah'],
            ['role' => 'Wali Kelas'],
            ['role' => 'Mitra Kelas'],
            ['role' => 'Wali Murid'],
        ];
        DB::table('role')->insert($data);
    }
}
