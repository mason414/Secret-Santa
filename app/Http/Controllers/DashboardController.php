<?php
namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function dashboard(Request $request): Response
    {
        // Get the currently authenticated user
        $currentUser = Auth::user();
        
        // Get all users
        $users = User::all();
        // Exclude users whose ID appears in any other user's user_id column
        $excludedUserIds = User::pluck('user_id')->toArray();
        
        // Check if the user has already been assigned a secretSanta
        $firstTime = false;
        
        if ($currentUser->user_id) {
            // If the user already has a user_id (i.e., assigned a secretSanta), return that user
            $secretSanta = User::find($currentUser->user_id);
        } else {
            // Otherwise, handle the first time assignment of Secret Santa
            $firstTime = true;
            
            // Filter out excluded users and the current user
            $filteredUsers = $users->filter(function ($user) use ($excludedUserIds, $currentUser) {
                return !in_array($user->id, $excludedUserIds) && $user->id !== $currentUser->id;
            });

            if($filteredUsers->count() == 0) {
              return Inertia::render('Dashboard');
            }
            
            // Pick a random user from the filtered list
            $secretSanta = $filteredUsers->random();
        }
        $wishlist = $secretSanta->wishlist()->get();
        // Return the Inertia response with all users and the selected secretSanta
        return Inertia::render('Dashboard', [
            'firstTime' => $firstTime,
            'users' => $users,
            'secretSanta' => $secretSanta,
            'wishlist' => $wishlist
        ]);
    }

    public function update($secretSantaId) {
      $currentUser = Auth::user();
      // Update the current user's user_id to reflect the assigned Secret Santa
      $currentUser->update(['user_id' => $secretSantaId]);
    }
}
