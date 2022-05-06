<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Company;
use App\Models\Proposal;
use App\Models\Job;
use Tests\TestCase;

class ProposalControllerTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    // Test List Freelancer Proposal
    public function testListFreelancerProposal()
    {
        $job = Job::factory()->create([
            'user_id'   => $this->user->id,
        ]);

        $proposals = Proposal::factory()->for($this->user)->create([
            'user_id'       => $this->user->id,
            'job_id'        => $job->id,
        ]);

        $SortType = 'ASC';
        $Search = '';
        $this->json('GET', 'api/proposal/list?SortField=created_at&SortType=' . $SortType . '&search= ' . $Search . '')
            ->assertOk();
    }

    // Test Show Detail Freelancer Proposal
    public function testShowDetailFreelancerProposal()
    {
        $job = Job::factory()->create([
            'user_id'        => $this->user->id,
        ]);
        $proposal = Proposal::factory()->create([
            'job_id'        => $job->id,
        ]);
        $this->json('GET', 'api/proposal/detail/' . $proposal->id)->assertOk();
    }
}
