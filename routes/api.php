<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\SqueezeController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\Admin\BlogController;
use App\Http\Controllers\Api\V1\Admin\CustomerController;
use App\Http\Controllers\Api\V1\Admin\Plan\FeatureController;
use App\Http\Controllers\Api\V1\Admin\Plan\SubscriptionController;
use App\Http\Controllers\Api\V1\Testimonial\TestimonialController;

use App\Http\Controllers\Api\V1\Organisation\OrganisationController;
use App\Http\Controllers\Api\V1\Organisation\OrganisationRemoveUserController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Middleware\LoginAttempts;



use App\Http\Controllers\Api\V1\JobController;
use App\Http\Controllers\BlogDeleteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        return 'api scaffold';
    });
    Route::post('/auth/register', [AuthController::class, 'store']);
    Route::post('/auth/login', [LoginController::class, 'login']);
    Route::post('/auth/logout', [LoginController::class, 'logout'])->middleware('auth:api');
    Route::post('/roles', [RoleController::class, 'store']);

    Route::apiResource('/users', UserController::class);

    Route::get('/products/categories', [CategoryController::class, 'index']);

    Route::middleware('throttle:10,1')->get('/topics/search', [ArticleController::class, 'search']);


    Route::middleware('auth:api')->group(function() {
        Route::post('/products', [ProductController::class, 'store']);
    });
      
    Route::middleware('throttle:10,1')->get('/help-center/topics/search', [ArticleController::class, 'search']);
    Route::post('/contact', [ContactController::class, 'sendInquiry']);

    Route::get('/blogs/latest', [BlogController::class, 'latest']);

    Route::post('/squeeze', [SqueezeController::class, 'store']);
    Route::middleware('auth:api')->group(function () {
        Route::apiResource('/features', FeatureController::class);
        Route::apiResource('/plans', SubscriptionController::class);
        Route::post('/organisations', [OrganisationController::class, 'store']);
    });

    Route::middleware('auth.jwt')->group(function () {
        Route::get('/organisations', [OrganisationController::class, 'index']);
        Route::delete('/organisations/{org_id}/users/{user_id}', [OrganisationRemoveUserController::class, 'removeUser']);
    });
    Route::middleware(['auth:api', 'admin'])->get('/customers', [CustomerController::class, 'index']);



    Route::middleware('auth:api')->group(function () {
        Route::post('/testimonials', [TestimonialController::class, 'store']);
        Route::get('/testimonials/{testimonial_id}', [TestimonialController::class, 'show']);
        Route::get('/jobs', [JobController::class, 'index']);
    });
   

    
});

Route::middleware('auth:api')->group(function () {
    Route::delete('/v1/blogs/{id}', [BlogDeleteController::class, 'destroy']);

});

    Route::delete('/v1/blogs/{id}', [BlogDeleteController::class, 'destroy']);
    Route::match(['get', 'post', 'put', 'patch'], '/v1/blogs/{id}', [BlogDeleteController::class, 'methodNotAllowed']);




