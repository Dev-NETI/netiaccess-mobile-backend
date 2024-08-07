<?php

use App\Http\Controllers\BrgyController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DialingCodeController;
use App\Http\Controllers\DormitoryController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\PaymentmodeController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\TransportationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('courses', CoursesController::class)->only([
    'index',
    'show',
])->middleware(['auth:sanctum']);
Route::get('courses/selected/{courseId}', [CoursesController::class, 'showCourse'])->middleware(['auth:sanctum']);

Route::resource('enrollment', EnrollmentController::class)->only([
    'store',
    'show',
])->middleware(['auth:sanctum']);
Route::get('enrollment/showSelectedCourse/{enroledId} ', [EnrollmentController::class, 'showSelectedCourse'])->middleware(['auth:sanctum']);
Route::get('enrollment/check/{courseId}/{traineeId}', [EnrollmentController::class, 'checkExistingEnrollment'])->middleware(['auth:sanctum']);
Route::get('enrollment/getLatestEnrollment/{traineeId}', [EnrollmentController::class, 'getLatestEnrollment'])->middleware(['auth:sanctum']);

Route::resource('schedule', ScheduleController::class)->only([
    'show'
])->middleware(['auth:sanctum']);

Route::resource('dormitory', DormitoryController::class)->only([
    'show'
])->middleware(['auth:sanctum']);

Route::resource('transportation', TransportationController::class)->only([
    'index'
])->middleware(['auth:sanctum']);

Route::get('payment-mode/{courseId}/{fleetId}', [PaymentmodeController::class, 'show'])->middleware(['auth:sanctum']);

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

Route::get('trainee/get-trainee-id/{email}', [TraineeController::class, 'getTraineeId']);
Route::get('trainee/check-email/{email}', [TraineeController::class, 'checkEmail']);
Route::get('trainee/check-mobile/{dialingCodeId}/{mobileNumber}', [TraineeController::class, 'checkMobile']);
Route::get('trainee/address/{traineeId}', [TraineeController::class, 'getTraineeAddressDropdown']);
Route::get('trainee/employment-info/{traineeId}', [TraineeController::class, 'getTraineeEmployment']);
Route::patch('trainee/updatePassword/{traineeId}', [TraineeController::class, 'updatePassword']);
Route::patch('trainee/updateAddress/{traineeId}', [TraineeController::class, 'updateAddress']);
Route::patch('trainee/updateEmployment/{traineeId}', [TraineeController::class, 'updateEmployment']);
Route::put('trainee/updateContact/{traineeId}', [TraineeController::class, 'updateContact']);
Route::resource('trainee', TraineeController::class)->only(['store', 'show', 'update']);

Route::get('email/send-verification-code/{recipient}/{verificationCode}', [EmailController::class, 'sendVerificationCode']);

Route::get('user/rank/{rankId}', [UserController::class, 'getRank']);
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
