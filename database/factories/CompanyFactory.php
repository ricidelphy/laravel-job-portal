<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'user_id'           => (User::factory()->create())->id,
            'company_name'      =>  $this->faker->name,
            'company_logo'      =>  $this->faker->userName . '.' . $this->faker->fileExtension(),
            'about'             =>  $this->faker->realText,
            'website'           =>  $this->faker->domainName,
        ];
    }
}
