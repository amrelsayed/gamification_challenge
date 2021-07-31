<?php

namespace App\Events;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BadgeUnlocked
{
    use Dispatchable, SerializesModels;

    public $badge;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Badge $badge, User $user)
    {
        $this->badge = $badge;
        $this->user = $user;
    }
}
