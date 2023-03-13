<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'zip_code' => $this->faker->numerify('########'),
            'street' => $this->faker->streetName,
            'number' => $this->faker->numerify('#####'),
            'complement' => $this->faker->secondaryAddress,
            'district' => $this->faker->company,
            'city' => $this->faker->jobTitle,
            'state' => $this->faker->lexify('??')
        ];
    }
}
