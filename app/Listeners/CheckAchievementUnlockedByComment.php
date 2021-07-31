<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\CommentWritten;
use App\Models\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckAchievementUnlockedByComment
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
     * @param  CommentWritten  $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        
        $comment = $event->comment;
        $user = $comment->user;

        $user_comments_count = $user->loadCount('comments')->comments_count;
        
        $deserved_achievment = Achievement::where('type', Achievement::TYPES['COMMENT_WRITTEN'])
            ->where('points', $user_comments_count)
            ->first();

        if ($deserved_achievment) {
            AchievementUnlocked::dispatch($deserved_achievment, $user);
        }
    }
}
