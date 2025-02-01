<?php

namespace Database\Factories;

use App\Models\Roles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Roles>
 */
class RolesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Roles::class;

    public function definition()
    {
       /*  return [
            'name' => fake()->unique()->randomElement(['admin', 'seller'], false),// pode have inconsistencia nessa parte pois o codigo do admin pode ser tanto 01 quanto 02 no db
        ]; */
    }
}
