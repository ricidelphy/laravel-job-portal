<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Models\Job;
use App\Models\User;
use App\Models\Category;
use App\Models\Proposal;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
        $this->user->assignRole('Freelancer');
    }

    // Test Home Website
    public function testHomeWebsite()
    {
        $category = Category::factory()->create();
        $jobs = Job::factory()->count(5)->create([
            'category_id'   => $category->id,

        ]);

        $this->json('GET', 'api')->assertOk();
    }

    // Test Show Detail Job
    public function testShowDetailJob()
    {
        $category = Category::factory()->create();
        $jobs = Job::factory()->create([
            'category_id'   => $category->id,

        ])->first();

        $this->json('GET', 'api/job/show/' . $jobs->id)->assertOk();
    }

    // Test Apply Job Exists
    public function testApplyJobExists()
    {

        $job = Job::factory()->create([
            'user_id'           => $this->user->id,
        ]);

        $proposal = Proposal::factory()->create();

        $this->json('POST', 'api/job/apply', [

            'job_id'            => $job->id,
            'user_id'           => $this->user->id,

        ]);

        $this->assertModelExists($proposal);
    }

    // Test Apply Job Success
    public function testApplyJobSuccess()
    {
        $job = Job::factory()->create();

        $this->json('POST', 'api/job/apply', [
            'user_id'       => $this->user->id,
            'job_id'        => $job->id,
            'status'        => 'send'
        ])->assertOk();

        $this->assertDatabaseHas('proposals', [
            'user_id'           => $this->user->id,
            'job_id'            => $job->id,
            'status'            => 'send'
        ]);
    }
}
