<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('achievements')->insert([
            [
		        'name' => 'First Lesson Watched',
		        'type' => Achievement::TYPES['LESSON_WATCHED'],
	        	'points' => 1,
            ],
            [
		        'name' => '5 Lessons Watched',
		        'type' => Achievement::TYPES['LESSON_WATCHED'],
	        	'points' => 5,
            ],
            [
		        'name' => '10 Lessons Watched',
		        'type' => Achievement::TYPES['LESSON_WATCHED'],
	        	'points' => 10,
            ],
            [
		        'name' => '25 Lessons Watched',
		        'type' => Achievement::TYPES['LESSON_WATCHED'],
	        	'points' => 25,
            ],
            [
		        'name' => '50 Lessons Watched',
		        'type' => Achievement::TYPES['LESSON_WATCHED'],
	        	'points' => 50,
            ],
            [
		        'name' => 'First Comment Written',
		        'type' => Achievement::TYPES['COMMENT_WRITTEN'],
	        	'points' => 1,
            ],
            [
		        'name' => '3 Comments Written',
		        'type' => Achievement::TYPES['COMMENT_WRITTEN'],
	        	'points' => 3,
            ],
            [
		        'name' => '5 Comments Written',
		        'type' => Achievement::TYPES['COMMENT_WRITTEN'],
	        	'points' => 5,
            ],
            [
		        'name' => '10 Comment Written',
		        'type' => Achievement::TYPES['COMMENT_WRITTEN'],
	        	'points' => 10,
            ],
            [
		        'name' => '20 Comment Written',
		        'type' => Achievement::TYPES['COMMENT_WRITTEN'],
	        	'points' => 20,
            ],
        ]);
    }
}
