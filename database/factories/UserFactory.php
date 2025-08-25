<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Enums\UserRole;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // simple default password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn () => ['email_verified_at' => null]);
    }

    /**
     * Assign a default role when creating the user.
     */
    public function withRole(UserRole|array $roles): static
    {
        return $this->afterCreating(function (User $user) use ($roles) {
            $roles = is_array($roles) ? $roles : [$roles];
            foreach ($roles as $role) {
                $roleModel = Role::firstOrCreate(['name' => $role->value]);
                $user->assignRole($roleModel);
            }
        });
    }
}
