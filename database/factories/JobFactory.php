<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;
use App\Models\User;
use App\Models\Category;

class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id'        => (Company::factory()->create())->id,
            'job_name'          => $this->faker->name,
            'job_description'   => $this->faker->realText,
            'user_id'           => (User::factory()->create())->id,
            'published'         => $this->faker->boolean(),
            'category_id'       => (Category::factory()->create())->id
        ];
    }
}
