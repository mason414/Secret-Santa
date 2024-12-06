<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wishlist>
 */
class WishlistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random user ID from the User table
        $userId = User::inRandomOrder()->first()->id;

        return [
            'user_id' => $userId,  // Assign the random user ID to each wishlist entry
            'wish' => $this->faker->randomElement([
                'car', 
                'ps5', 
                'dog', 
                'monkey', 
                'stuffed animal', 
                'barbie doll', 
                'xbox controller', 
                'streaming service subscription'
            ])
        ];
    }
}
