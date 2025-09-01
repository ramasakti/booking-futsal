<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelCBISeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['level' => 'Pra Prafonik'],
            ['level' => 'Prafonik'],
            ['level' => 'Dasar'],
            ['level' => 'Terampil'],
            ['level' => 'Mahir']
        ];
        DB::table('level_cbi')->insert($data);
    }
}
