<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\View\View;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('editor.editor', 'App\Http\ViewComposers\EditorComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
