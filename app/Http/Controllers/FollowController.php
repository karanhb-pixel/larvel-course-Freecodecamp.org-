<?php

namespace App\Http\Controllers;

use App\Models\User;

class FollowController extends Controller
{
    /**
     * Toggle the follow status for the given user by the authenticated user and return the updated followers count.
     *
     * @param  User  $user  The user to follow or unfollow.
     * @return \Illuminate\Http\JsonResponse JSON response containing the followers count.
     */
    public function followUnfollow(User $user)
    {

        $user->followers()->toggle(auth()->user());

        return response()->json([
            'followers_count' => $user->followers()->count(),
        ]);
    }
}
