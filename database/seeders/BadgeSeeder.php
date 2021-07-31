<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('badges')->insert([
            [
		        'name' => 'Beginner',
	        	'points' => 0,
            ],
            [
		        'name' => 'Intermediate',
	        	'points' => 4,
            ],
            [
		        'name' => 'Advanced',
	        	'points' => 8,
            ],
            [
		        'name' => 'Master',
	        	'points' => 10,
            ],
        ]);
    }
}
