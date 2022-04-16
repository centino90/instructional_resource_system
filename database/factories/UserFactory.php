<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $roles = [Role::PROGRAM_DEAN, Role::SECRETARY, ROLE::INSTRUCTOR];

        return [
            'fname' => $this->faker->firstName(),
            'lname' => $this->faker->lastName(),
            'username' => $this->faker->unique()->username,
            'password' => Hash::make('password'), // password
            'role_id' => $roles[rand(0, 2)],
            'contact_no' => $this->faker->phoneNumber(),
            'email' => $this->faker->email()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
