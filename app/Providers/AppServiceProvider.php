<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domains\Question\QuestionRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(QuestionRepository::class)
            ->needs('$db_type')
            ->give(env('QUESTION_DATABASE_TYPE'));
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
