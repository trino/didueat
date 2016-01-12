<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider {

    public function boot() {
        $this->app['validator']->extend('phone_number', function ($attribute, $value, $parameters) {
            return strlen(preg_replace('#^.*([0-9]{3})[^0-9]*([0-9]{3})[^0-9]*([0-9]{4})$#', '$1$2$3', $value)) == 10;
        });

        $this->app['validator']->extend('postal_code', function ($attribute, $value, $parameters) {
            return (bool) preg_match('/^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ] ?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/i', $value);
        });
    }

    public function postal_code($field, $value, $parameters){
        return (bool) preg_match('/^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ] ?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/i', $value);
    }

    public function register() {
        //
    }
}