<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\MyProposalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Home Only

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'list_job');

    Route::prefix('job')->group(function () {

        Route::get('detail/{id}', 'show');
        // Apply
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('apply', 'apply');
        });
    });
});

// Authenticated
Route::controller(AuthController::class)->prefix('auth')->group(function () {

    Route::post('login', 'login');
    // Logout
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', 'logout');
    });

    Route::prefix('employeer')->group(function () {
        Route::post('register', 'register_employeer');
    });

    Route::prefix('freelancer')->group(function () {
        Route::post('register', 'register_freelancer');
    });
});



// Auth Only
Route::middleware('auth:sanctum')->group(function () {

    // Freelancer Only
    Route::controller(MyProposalController::class)->group(function () {

        Route::prefix('my-proposal')->group(function () {
            Route::get('list', 'index');
            Route::get('detail/{id}', 'show');
        });
    });

    // Freelancer Only
    Route::controller(ProfileController::class)->prefix('my-profile')->group(function () {
        Route::get('detail/{id}', 'show');
        Route::post('update/{id}', 'update');
    });


    // Employeer Only
    Route::controller(CompanyController::class)->prefix('company')->group(function () {
        Route::get('list', 'index');
        Route::post('save', 'store');
        Route::get('detail', 'show');
        Route::post('update', 'update');
        Route::delete('delete', 'destroy');
    });

    Route::controller(JobController::class)->prefix('job')->group(function () {
        Route::get('list', 'index');
        Route::post('save', 'store');
        Route::get('detail/{id}', 'show');
        Route::put('update/{id}', 'update');
        Route::delete('delete/{id}', 'destroy');
    });

    Route::controller(ProposalController::class)->prefix('proposal')->group(function () {
        Route::get('list', 'index');
        Route::get('detail/{id}', 'show');
        Route::put('update/{id}', 'update');
        Route::delete('delete/{id}', 'destroy');
    });

    Route::controller(CategoryController::class)->prefix('category')->group(function () {
        Route::get('list', 'index');
        Route::post('save', 'store');
        Route::get('detail/{id}', 'show');
        Route::put('update/{id}', 'update');
        Route::delete('delete/{id}', 'destroy');
    });
});
