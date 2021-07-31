<?php

namespace App\Actions\Achievement;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;

class ListUserAchievementsAction
{
	public function execute(User $user)
	{
		$unlocked_achievements = $user->achievements()->pluck('name')->toArray();

		$next_available_achievements = [];

		$next_lesson_watched_achievement = $this->nextAvailableAchievement($user, Achievement::TYPES['LESSON_WATCHED']);
        
        if ($next_lesson_watched_achievement) {
            $next_available_achievements[] = $next_lesson_watched_achievement->name;
        }

        $next_comment_written_achievement = $this->nextAvailableAchievement($user, Achievement::TYPES['COMMENT_WRITTEN']);

        if ($next_comment_written_achievement) {
            $next_available_achievements[] = $next_comment_written_achievement->name;
        }

        $next_badge = Badge::where('points', '>', $user->badge->points)
            ->first();

        $remaing_to_unlock_next_badge = 0;
        
        if ($next_badge) {
            $remaing_to_unlock_next_badge = $next_badge->points - count($unlocked_achievements);
        }

        return [
            'unlocked_achievements' => $unlocked_achievements,
            'next_available_achievements' => $next_available_achievements,
            'current_badge' => $user->badge->name,
            'next_badge' => $next_badge ? $next_badge->name : '',
            'remaing_to_unlock_next_badge' => $remaing_to_unlock_next_badge
        ];
	}

	private function nextAvailableAchievement(User $user, int $type)
	{
		$latest_reserved_achievement = $user->achievements()
            ->where('type', $type)
            ->latest('id')
            ->first();
        
        if (! $latest_reserved_achievement) {
        	return Achievement::where('type', $type)
            	->first();
        }
        
        return $next_available_achievement = Achievement::where('type', $type)
            ->where('points', '>', $latest_reserved_achievement->points)
            ->first();
	}
}