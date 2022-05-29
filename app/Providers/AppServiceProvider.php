<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Interfaces\Models\MUserRepositoryInterface::class,
            \App\Repositories\Models\MUserRepository::class
        );

        $this->app->bind(
            \App\Interfaces\Models\TSendMailRepositoryInterface::class,
            \App\Repositories\Models\TSendMailRepository::class
        );

        $this->app->bind(
            \App\Interfaces\Emails\SendMailRepositoryInterface::class,
            \App\Repositories\Emails\SendMailRepository::class
        );

        $this->app->bind(
            \App\Interfaces\BusinessLogics\CreatePreRepositoryInterface::class,
            \App\Repositories\BusinessLogics\CreatePreRepository::class
        );

        $this->app->bind(
            \App\Interfaces\BusinessLogics\CreateRepositoryInterface::class,
            \App\Repositories\BusinessLogics\CreateRepository::class
        );

        $this->app->bind(
            \App\Interfaces\BusinessLogics\PasswordResetPreRepositoryInterface::class,
            \App\Repositories\BusinessLogics\PasswordResetPreRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
