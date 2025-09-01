<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AksesRoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = DB::table('menu')->get();
        foreach ($menus as $menu) {
            DB::table('access_role')
                ->insert([
                    'role_id' => 1,
                    'menu_id' => $menu->id
                ]);
        }
    }
}
