<?php

namespace App\Providers;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Listeners\AddAchievementToUser;
use App\Listeners\AddBadgeToUser;
use App\Listeners\CheckAchievementUnlockedByComment;
use App\Listeners\CheckAchievementUnlockedByLesson;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentWritten::class => [
            CheckAchievementUnlockedByComment::class
        ],
        LessonWatched::class => [
            CheckAchievementUnlockedByLesson::class
        ],
        AchievementUnlocked::class => [
            AddAchievementToUser::class
        ],
        BadgeUnlocked::class => [
            AddBadgeToUser::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
