<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Spatie\ImageOptimizer\OptimizerChain;

class OptimizeImages
{
    protected $optimizerChain;
    protected $manager;

    public function __construct(OptimizerChain $optimizerChain)
    {
        $this->optimizerChain = $optimizerChain;
        $this->manager = new ImageManager(Driver::class);
    }

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!$this->isImageResponse($response)) {
            return $response;
        }

        $image = $this->manager->read($response->getContent());

        // Resize if larger than 2000px
        if ($image->width() > 2000) {
            $image->scale(2000);
        }

        // Convert to WebP if browser supports it
        if (str_contains($request->header('Accept'), 'image/webp')) {
            $image->encodeByExtension('webp', 85);
            $response->header('Content-Type', 'image/webp');
        }

        $response->setContent($image->toJpeg());

        // Optimize the image
        $this->optimizerChain->optimize($response->getContent());

        return $response;
    }

    protected function isImageResponse($response)
    {
        return $response->headers->has('Content-Type') &&
               str_contains($response->headers->get('Content-Type'), 'image');
    }
}
