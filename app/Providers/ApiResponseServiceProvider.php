<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use App\Libs\AppConstants;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * response macro
     *
     * @return void
     */
    public function boot()
    {
        Response::macro(AppConstants::KEY_SUCCESS, function ($response) {
            return response()->json([
                AppConstants::KEY_SUCCESS => true,
                AppConstants::KEY_RESPONSE => $response
            ], 200);
        });

        Response::macro(AppConstants::KEY_ERR, function ($error) {
            return response()->json([
                AppConstants::KEY_SUCCESS => false,
                AppConstants::KEY_ERR => $error
            ], 400);
        });
    }
}
