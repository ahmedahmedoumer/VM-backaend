<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Property\PropertyController;
use App\Http\Controllers\Visitor\VisitorController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\CompanyController\CompanyController;
use App\Http\Controllers\VisitorLogController\VisitorLogController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->group(function () {
    // Route to create a new property
    Route::post('/properties', [PropertyController::class, 'store']);

    // Route to retrieve all properties
    Route::get('/properties', [PropertyController::class, 'index']);

    // Route to retrieve a specific property by ID
    Route::get('/properties/{id}', [PropertyController::class, 'show']);

    // Route to update an existing property
    Route::put('/properties/{id}', [PropertyController::class, 'update']);

    // Route to delete a property
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy']);
// });




// Route::middleware('auth:sanctum')->group(function () {
    // Route to create a new visitor
    Route::post('/visitors', [VisitorController::class, 'store']);

    // Route to retrieve all visitors
    Route::get('/visitors', [VisitorController::class, 'index']);

    // Route to retrieve a specific visitor by ID
    Route::get('/visitors/{id}', [VisitorController::class, 'show']);

    // Route to update an existing visitor
    Route::patch('/visitors/{id}', [VisitorController::class, 'update']);

    // Route to delete a visitor
    Route::delete('/visitors/{id}', [VisitorController::class, 'destroy']);

    // Route to check in a visitor
    Route::post('/visitors/{id}/checkin', [VisitorController::class, 'checkin']);

    // Route to check out a visitor
    Route::post('/visitors/{id}/checkout', [VisitorController::class, 'checkout']);
// });



// Route::middleware('auth:sanctum')->group(function () {
    // Route to create a new user
    Route::post('/users', [UserController::class, 'store']);

    // Route to retrieve all users
    Route::get('/users', [UserController::class, 'index']);

    // Route to retrieve a specific user by ID
    Route::get('/users/{id}', [UserController::class, 'show']);

    // Route to update an existing user
    Route::put('/users/{id}', [UserController::class, 'update']);

    // Route to delete a user
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    // Route to assign a role to a user
    Route::post('/users/{id}/assign-role', [UserController::class, 'assignRole']);

    // Route to remove a role from a user
    Route::post('/users/{id}/remove-role', [UserController::class, 'removeRole']);


    Route::post('/companies', [CompanyController::class, 'store']);

    // Route to retrieve all users
    Route::get('/companies', [CompanyController::class, 'index']);

    // Route to retrieve a specific user by ID
    Route::get('/companies/{id}', [CompanyController::class, 'show']);

    // Route to update an existing user
    Route::put('/companies/{id}', [CompanyController::class, 'update']);

    // Route to delete a user
    Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);

    // Route to assign a role to a use
// });

Route::post('/checkin', [VisitorLogController::class, 'checkIn']);
Route::post('/checkout/{id}', [VisitorLogController::class, 'checkOut']);
Route::get('/visitor-logs', [VisitorLogController::class, 'index']);
Route::get('/visitor-logs/{id}', [VisitorLogController::class, 'show']);
Route::delete('/visitor-logs/{id}', [VisitorLogController::class, 'destroy']);
