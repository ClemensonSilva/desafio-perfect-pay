<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use app\Models\Roles;
use App\Models\Users;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class UsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Users::class;

    public function definition()
    {
        $role = [1,2];
        $password = crypted(fake()->word());
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'role_id' => fake()->randomElement($role),
            'password' => $password, // password
        ];
    }
}
