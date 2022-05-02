<?php

namespace ArtSites\NovaSeo;

use ArtSites\NovaSeo\Resources\SEO;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
                __DIR__.'/migrations/2020_03_10_120159_create_seo_table.php' => database_path('/migrations/2020_03_10_120159_create_seo_table.php'),
        ], 'migration');
        $this->publishes([
            __DIR__.'/Models/SEO.php' => app_path('/Models/SEO.php'),
        ], 'model');
        $this->publishes([
            __DIR__.'/Resource/SEO.php' => app_path('/Nova/SEO.php'),
        ], 'nova-resource');

        Nova::serving(function (ServingNova $event) {
            Nova::script('seo-field', __DIR__.'/../dist/js/field.js');
            Nova::style('seo-field', __DIR__.'/../dist/css/field.css');
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
