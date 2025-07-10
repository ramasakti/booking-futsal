<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitusiSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['institusi' => 'PI'],
            ['institusi' => 'TPA'],
            ['institusi' => 'PG'],
            ['institusi' => 'TK'],
            ['institusi' => 'SDI'],
            ['institusi' => 'SDI2'],
            ['institusi' => 'SMP'],
            ['institusi' => 'SMA'],
            ['institusi' => 'HS'],
            ['institusi' => 'PTK'],
        ];
        DB::table('institusi')->insert($data);
    }
}
