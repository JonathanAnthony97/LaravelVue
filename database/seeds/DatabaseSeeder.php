<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ciscos')->insert([
            ['lieu_cisco' => 'FARAFANGANA'],
            ['lieu_cisco' => 'VANGAINDRANO'],
            ['lieu_cisco' => 'VONDROZO'],
            ['lieu_cisco' => 'BEFOTAKA'],
            ['lieu_cisco' => 'MIDONGY-SUD']
        ]);
    }
}
