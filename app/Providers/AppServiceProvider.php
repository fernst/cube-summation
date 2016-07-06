<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::setEchoFormat('nl2br(e(%s))');
        Blade::setContentTags('{{{', '}}}');
        Blade::setEscapedContentTags('{{', '}}');

        Validator::extend('greater_than_equal', function ($attribute, $value, $params, $validator) {
            $other = Input::get($params[0]);
            return intval($value) >= intval($other);
        });

        Validator::replacer('greater_than_equal', function ($message, $attribute, $rule, $params) {
            return str_replace('_', ' ', 'The ' . $attribute . ' must be greater than ' .
                'or equal to the ' . $params[0] . '.');
        });

        Validator::extend('less_than_equal', function ($attribute, $value, $params, $validator) {
            $other = Input::get($params[0]);
            return intval($value) <= intval($other);
        });

        Validator::replacer('less_than_equal', function ($message, $attribute, $rule, $params) {
            return str_replace('_', ' ', 'The ' . $attribute . ' must be less than ' .
                'or equal to the ' . $params[0] . '.');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
