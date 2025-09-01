<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AspekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['aspek' => 'Adab'],
            ['aspek' => 'Tanggung Jawab'],
            ['aspek' => 'Kemandirian'],
            ['aspek' => 'Kedisiplinan'],
            ['aspek' => 'Sosial'],
            ['aspek' => 'Pengenalan Ibadah Praktis'],
            ['aspek' => 'Berbakti Kepada Orang Tua'],
            ['aspek' => 'Pembiasaan'],
        ];
        DB::table('master_aspek')->insert($data);
    }
}
