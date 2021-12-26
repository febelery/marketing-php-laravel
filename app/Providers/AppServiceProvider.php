<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'vote' => 'App\Models\Vote\Vote',
            'lottery' => 'App\Models\Lottery\Lottery',
            'form' => 'App\Models\Form\Form',
        ]);
    }
}
