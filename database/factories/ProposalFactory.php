<?php

namespace Database\Factories;

use App\Models\Proposal;
use App\Models\User;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProposalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proposal::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'           => (User::factory()->create()->id),
            'job_id'            => (Job::factory()->create())->id,
            'status'            => 'send'
        ];
    }
}
