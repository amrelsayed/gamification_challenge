<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\LessonWatched;
use App\Models\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckAchievementUnlockedByLesson
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LessonWatched  $event
     * @return void
     */
    public function handle(LessonWatched $event)
    {
        $user = $event->user;
        $lesson = $event->lesson;

        $user->lessons()->updateExistingPivot($lesson->id, [
            'watched' => true,
        ]);

        $user_watched_count = $user->loadCount('watched')->watched_count;
        
        $deserved_achievment = Achievement::where('type', Achievement::TYPES['LESSON_WATCHED'])
            ->where('points', $user_watched_count)
            ->first();

        if ($deserved_achievment) {
            AchievementUnlocked::dispatch($deserved_achievment, $user);
        }
    }
}
