<?php

use App\Http\Controllers\BrgyController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DialingCodeController;
use App\Http\Controllers\DormitoryController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\PaymentmodeController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SendVerificationCodeController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('courses', CoursesController::class)->only([
    'index',
    'show',
]);
Route::get('courses/selected/{courseId}', [CoursesController::class, 'showCourse']);

Route::resource('enrollment', EnrollmentController::class)->only([
    'store',
    'show',
]);
Route::get('enrollment/showSelectedCourse/{enroledId} ', [EnrollmentController::class, 'showSelectedCourse']);
Route::get('enrollment/check/{courseId}/{traineeId}', [EnrollmentController::class, 'checkExistingEnrollment']);
Route::get('enrollment/getLatestEnrollment/{traineeId}', [EnrollmentController::class, 'getLatestEnrollment']);

Route::resource('schedule', ScheduleController::class)->only([
    'show'
]);

Route::resource('dormitory', DormitoryController::class)->only([
    'show'
]);

Route::resource('transportation', TransportationController::class)->only([
    'index'
]);

Route::get('payment-mode/{courseId}/{fleetId}', [PaymentmodeController::class, 'show']);

Route::resource('nationality', NationalityController::class)->only([
    'index', 'show'
]);

Route::resource('gender', GenderController::class)->only([
    'index', 'show'
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
Route::patch('trainee/updatePassword/{traineeId}', [TraineeController::class, 'updatePassword']);
Route::put('trainee/updateContact/{traineeId}', [TraineeController::class, 'updateContact']);
Route::resource('trainee', TraineeController::class)->only(['store', 'show', 'update']);

Route::get('send-verification-code', SendVerificationCodeController::class);


Route::get('user/rank/{rankId}', [UserController::class, 'getRank']);
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
