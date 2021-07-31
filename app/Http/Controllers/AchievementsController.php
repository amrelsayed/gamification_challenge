<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        $unlocked_achievements = $user->achievements()->pluck('name')->toArray();

        $latest_lesson_watched_achievement = $user->achievements()
            ->where('type', Achievement::TYPES['LESSON_WATCHED'])
            ->latest('id')
            ->first();
        
        $next_lesson_watched_achievement = Achievement::where('type', Achievement::TYPES['LESSON_WATCHED'])
            ->where('points', '>', $latest_lesson_watched_achievement->points)
            ->first();
        
        $latest_comment_written_achievement = $user->achievements()
            ->where('type', Achievement::TYPES['COMMENT_WRITTEN'])
            ->latest('id')
            ->first();

        $next_comment_written_achievement = Achievement::where('type', Achievement::TYPES['COMMENT_WRITTEN'])
            ->where('points', '>', $latest_comment_written_achievement->points)
            ->first();

        $next_available_achievements = [];

        if ($next_lesson_watched_achievement) {
            $next_available_achievements[] = $next_lesson_watched_achievement->name;
        }

        if ($next_comment_written_achievement) {
            $next_available_achievements[] = $next_comment_written_achievement->name;
        }

        $next_badge = Badge::where('points', '>', $user->badge->points)
            ->first();

        $remaing_to_unlock_next_badge = 0;
        
        if ($next_badge) {
            $remaing_to_unlock_next_badge = $next_badge->points - count($unlocked_achievements);
        }

        return response()->json([
            'unlocked_achievements' => $unlocked_achievements,
            'next_available_achievements' => $next_available_achievements,
            'current_badge' => $user->badge->name,
            'next_badge' => $next_badge ? $next_badge->name : '',
            'remaing_to_unlock_next_badge' => $remaing_to_unlock_next_badge
        ]);
    }
}
