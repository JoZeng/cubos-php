<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
   
    
        Validator::extend('cpf', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/\d{3}\.\d{3}\.\d{3}\-\d{2}/', $value);
        });
    
        Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/\(\d{2}\) \d{4,5}-\d{4}/', $value);
        });
    }
}
