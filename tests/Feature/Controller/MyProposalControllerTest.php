<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Company;
use App\Models\Proposal;
use Tests\TestCase;

class MyProposalControllerTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function testListMyFreelancerProposal()
    {
        $proposals = Proposal::factory()->create([
            'user_id'       => $this->user->id,
        ]);
        $SortType = 'ASC';
        $Search = '';

        $this->json('GET', 'api/my-proposal/list?SortField=created_at&SortType=' . $SortType . '&search= ' . $Search . '',)
            ->assertOk();
    }
}
