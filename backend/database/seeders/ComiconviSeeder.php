<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComiconviSeeder extends Seeder
{
    public function run(): void
    {
        $comiconvis = [
            ['idMiembro' => 1],
            ['idMiembro' => 2]
        ];

        foreach ($comiconvis as $comiconvi) {
            DB::table('comiconvis')->insert($comiconvi);
        }
    }
} 