<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Libs\AppConstants;
use App\Http\Controllers\Users\LoginController;
use App\Http\Controllers\Users\CreatePreController;
use App\Http\Controllers\Users\CreateController;
use App\Http\Controllers\Users\PasswordResetPreController;

Route::get(AppConstants::ROOT_DIR_USERS_CREATE, [CreateController::class, 'show']);

Route::post('/', [LoginController::class, 'login']);
Route::post(AppConstants::ROOT_DIR_USERS_CREATE_PRE, [CreatePreController::class, 'store']);
Route::post(AppConstants::ROOT_DIR_USERS_PASSWORD_RESET_PRE, [PasswordResetPreController::class, 'store']);

Route::match(['get','post'], AppConstants::ROOT_DIR_USERS_CREATE . '/{email_verify_token}', [CreateController::class, 'show']);

