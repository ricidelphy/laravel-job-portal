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

// use Database\Factories\CompanyFactory;
// use Tests\TestCase;

class JobControllerTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }


    public function testListJobCompanyCreate()
    {

        $job = Job::factory()->create([
            'user_id'       => $this->user->id,
        ]);
        $this->json('GET', 'api/job/list', [])->assertOk();
    }


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

    public function testSaveJobSuccessfully()
    {

        $company = Company::factory()->create([
            'user_id'   => $this->user->id,
        ]);

        $category = Category::factory()->create();

        $this->postJson('api/job/save', [
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

    public function testUpdateJobSuccessfully()
    {
        $category = Category::factory()->create();
        $job = Job::factory()->create(['user_id' => $this->user->id]);

        $response = $this->json('PUT', 'api/job/update/' . $job->id, [
            'user_id'           => $this->user->id,
            'category_id'       => $category->id,
            'job_name'          => 'Fulltime WHO',
            'job_description'   => $job_description = 'Magang selama 3 Bulan.',
            'published'         => $published = 1,
        ])->assertOk();

        $job->refresh();
    }


    public function testDestroyJobSuccessfully()
    {
        $company = Company::factory()->create([
            'id'                => 2,
            'user_id'           => $this->user->id,
            'company_name'      => 'PT ABCD',
            'company_logo'      => 'no-image.png',
            'about'             => 'Teststs',
            'website'           => 'www.abcd.com'
        ]);

        $job = Job::factory()->create([
            'user_id'           => $this->user->id,
            'company_id'        => $company_id = $company->id,
            'category_id'       => $category_id = 1,
            'job_name'          => $job_name = 'Magang',
            'job_description'   => $job_description = 'Magang selama 3 Bulan.',
            'published'         => $published = 1,
        ]);

        $this->json('DELETE', 'api/job/delete/' . $job->id)
            ->assertOk();
    }
}
