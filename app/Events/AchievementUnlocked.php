<?php

namespace App\Events;

use App\Models\Achievement;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AchievementUnlocked
{
    use Dispatchable, SerializesModels;

    public $achievement;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Achievement $achievement, User $user)
    {
        $this->achievement = $achievement;
        $this->user = $user;
    }
}
