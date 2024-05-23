<?php

use App\Http\Controllers\BrgyController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DialingCodeController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TraineeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('courses', CoursesController::class)->only([
    'index',
    'show',
]);

Route::resource('nationality', NationalityController::class)->only([
    'index'
]);

Route::resource('gender', GenderController::class)->only([
    'index'
]);

Route::resource('dialing-code', DialingCodeController::class)->only([
    'index'
]);

Route::get('region', [RegionController::class, 'index']);
Route::get('state/{regCode}', [StateController::class, 'show']);
Route::get('city/{provCode}', [CityController::class, 'show']);
Route::get('brgy/{citymunCode}', [BrgyController::class, 'show']);

Route::resource('rank', RankController::class)->only([
    'index'
]);

Route::resource('company', CompanyController::class)->only([
    'index'
]);

Route::get('trainee/check-email/{email}', [TraineeController::class, 'checkEmail']);
Route::get('trainee/check-mobile/{dialingCodeId}/{mobileNumber}', [TraineeController::class, 'checkMobile']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
