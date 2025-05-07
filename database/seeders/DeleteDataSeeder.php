<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeleteDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('acciones')->whereIn('nombre', [
            'Conservación',
            'Investigación',
            'Educación Ambiental',

        ])->delete();
    }
}
