<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Intervention\Image\ImageManager;
use Spatie\ImageOptimizer\OptimizerChain;

class ImageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('image', function ($app) {
            return new ImageManager('gd');
        });

        $this->app->bind(OptimizerChain::class, function ($app) {
            return (new OptimizerChain())
                ->addOptimizer(new \Spatie\ImageOptimizer\Optimizers\Jpegoptim([
                    '--strip-all',
                    '--all-progressive',
                    '--max=85'
                ]))
                ->addOptimizer(new \Spatie\ImageOptimizer\Optimizers\Pngquant([
                    '--force',
                    '--quality=80-85'
                ]))
                ->addOptimizer(new \Spatie\ImageOptimizer\Optimizers\Optipng([
                    '-i0',
                    '-o2',
                    '-quiet'
                ]))
                ->addOptimizer(new \Spatie\ImageOptimizer\Optimizers\Svgo([
                    '--disable=cleanupIDs'
                ]))
                ->addOptimizer(new \Spatie\ImageOptimizer\Optimizers\Gifsicle([
                    '-b',
                    '-O3'
                ]));
        });
    }

    public function boot()
    {
        //
    }
}
