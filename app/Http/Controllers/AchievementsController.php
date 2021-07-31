<?php

namespace App\Http\Controllers;

use App\Actions\Achievement\ListUserAchievementsAction;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(
        User $user, 
        ListUserAchievementsAction $listUserAchievementsAction
    ) {
        $user_achievments = $listUserAchievementsAction->execute($user);

        return response()->json($user_achievments);
    }
}
