<?php

namespace FlickrPhotoSearch\Providers;

use Illuminate\Support\ServiceProvider;
use FlickrPhotoSearch\Tools\Flickr;

class FlickrServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //echo 'string';

        $this->app->singleton('flickrtool', function(){
            return new Flickr;
        });
    }
}
