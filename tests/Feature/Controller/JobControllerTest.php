<?php

namespace Tests\Feature\Controller;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Company;
use App\Models\Job;
use Tests\TestCase;

class JobControllerTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
        $this->user->assignRole('Employeer');
    }

    // Test List Job Company Create
    public function testListJobCompanyCreated()
    {
        $company = Company::factory()->create([
            'user_id'   => $this->user->id,
        ]);
        $category = Category::factory()->create();

        $jobs = Job::factory()->create([
            'company_id'    => $company->id,
            'category_id'   => $category->id
        ]);
        $SortType = 'ASC';
        $Search = '';
        $this->json(
            'GET',
            'api/job/list?SortField=created_at&SortType=' . $SortType . '&search= ' . $Search . ''
        )->assertOk();
    }

    // Test Save Failed Job Validation Error
    public function testSaveJobFailedDueToValidationErrors()
    {
        $this->json('POST', 'api/job/save', [
            'category_id'       => '',
            'job_name'          => '',
            'job_description'   => '',
            'published'         => '',
        ])
            ->assertInvalid(['category_id', 'job_description', 'job_description', 'published']);
    }

    // Test Save Job Success
    public function testSaveJobSuccessfully()
    {

        $company = Company::factory()->create([
            'user_id'   => $this->user->id,
        ]);

        $category = Category::factory()->create();

        $this->json('POST', 'api/job/save', [
            'company_id'        => $company->id,
            'category_id'       => $category->id,
            'job_name'          => $job_name = 'Magang',
            'job_description'   => $job_description = 'Magang selama 3 Bulan.',
            'published'         => $published = 1,

        ])->assertOk();


        $this->assertDatabaseHas('jobs', [
            'company_id'        => $company->id,
            'category_id'       => $category->id,
            'job_name'          => $job_name,
            'job_description'   => $job_description,
            'published'         => $published
        ]);
    }

    // Test Show Detail My Job Created
    public function testShowDetailMyJobCreated()
    {
        $category = Category::factory()->create();
        $jobs = Job::factory()->create([
            'user_id'       => $this->user->id,
            'category_id'   => $category->id,

        ])->first();

        $this->json('GET', 'api/job/detail/' . $jobs->id)->assertOk();
    }

    // Test Update Job Success
    public function testUpdateJobSuccessfully()
    {
        $category = Category::factory()->create();
        $job = Job::factory()->create(['user_id' => $this->user->id]);

        $response = $this->json('PUT', 'api/job/update/' . $job->id, [
            'user_id'           => $this->user->id,
            'category_id'       => $category->id,
            'job_name'          => 'Fulltime WHO',
            'job_description'   => 'Magang selama 3 Bulan.',
            'published'         => 1, //Publis
        ])->assertOk();
    }

    // Test Delete Job Success
    public function testDestroyJobSuccessfully()
    {
        $company = Company::factory()->create();

        $job = Job::factory()->create([
            'user_id'           => $this->user->id,
            'company_id'        => $company->id,
        ]);

        $this->json('DELETE', 'api/job/delete/' . $job->id)
            ->assertOk();
    }
}
