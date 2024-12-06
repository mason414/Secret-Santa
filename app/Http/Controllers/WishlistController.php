<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WishlistController extends Controller
{
    /**
     * Show the wishlist of a user.
     *
     * @param int $userId
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $numberId = (int) $userId;
        $user = User::findOrFail($userId);  // Find the user by ID
        $wishlist = $user->wishlist()->get();
        return Inertia::render('Wishlist/Index', [
          'userName' => $user->name,
          'userId' => $numberId,
          'wishlist' => $wishlist,
      ]);
    }

    /**
     * Add an item to the user's wishlist.
     *
     * @param int $userId
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function add($userId, Request $request)
    {
        $request->validate([
            'wish' => 'required|string|max:255',  // Validate wish input
        ]);

        $user = User::findOrFail($userId);  // Find the user

        // Create a new wishlist item for the user
        $user->wishlist()->create([
            'wish' => $request->wish,
        ]);

        $wishlist = $user->wishlist()->get();
        return Inertia::render('Wishlist/Index', [
            'wishlist' => fn () => $wishlist,
        ]);
    }

    /**
     * Remove an item from the user's wishlist.
     *
     * @param int $userId
     * @param int $wishId
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, $wishId)
    {
        $user = User::findOrFail($userId);  // Find the user

        // Find and delete the wishlist item
        $user->wishlist()->where('id', $wishId)->delete();

        $wishlist = $user->wishlist()->get();
        return Inertia::render('Wishlist/Index', [
          'wishlist' => fn () => $wishlist,
        ]);
    }

    /**
     * Update the user's wishlist.
     *
     * @param int $userId
     * @param int $wishId
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update($userId, $wishId, Request $request)
    {
        $user = User::findOrFail($userId);  // Find the user

        $user->wishlist()->where('id', $wishId)->update(['wish' => $request->wish]);

        // $wishlist = $user->wishlist()->get();
        // return Inertia::render('Wishlist/Index', [
        //   'wishlist' => fn () => $wishlist,
        // ]);
    }
}
