<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->userName,
            'last_name' => $this->faker->lastName,
            'birth_date' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['F', 'M']),
            'code' => $this->faker->randomNumber(6)
        ];
    }
}
