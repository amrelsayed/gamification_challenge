<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Badge;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddAchievementToUser
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
     * @param  AchievementUnlocked  $event
     * @return void
     */
    public function handle(AchievementUnlocked $event)
    {
        $achievement = $event->achievement;
        $user = $event->user;

        $user->achievements()->syncWithoutDetaching($achievement->id);

        $achievements_count = $user->loadCount('achievements')->achievements_count;
        
        $deserved_badge = Badge::where('points', $achievements_count)
            ->first();
        
        if ($deserved_badge) {
            BadgeUnlocked::dispatch($deserved_badge, $user);
        }
    }
}
