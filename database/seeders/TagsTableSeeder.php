<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tags')->insert([
            ['name' => 'food'],
            ['name' => 'shop'],
            ['name' => 'event'],
            ['name' => 'volunteer'],
            ['name' => 'sightseeing'],
            ['name' => 'others'],
        ]);
    }
}
