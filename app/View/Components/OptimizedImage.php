<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;

class OptimizedImage extends Component
{
    public $src;
    public $alt;
    public $width;
    public $height;
    public $lazy;

    public function __construct($src, $alt = '', $width = null, $height = null, $lazy = true)
    {
        $this->src = $src;
        $this->alt = $alt;
        $this->width = $width;
        $this->height = $height;
        $this->lazy = $lazy;
    }

    public function render()
    {
        $cacheKey = 'img_' . md5($this->src . $this->width . $this->height);
        
        return Cache::remember($cacheKey, 60 * 24, function () {
            $imgUrl = $this->optimizeImage($this->src);
            
            return view('components.optimized-image', [
                'src' => $imgUrl,
                'alt' => $this->alt,
                'width' => $this->width,
                'height' => $this->height,
                'lazy' => $this->lazy
            ]);
        });
    }

    private function optimizeImage($src)
    {
        if (config('performance.cdn.enabled')) {
            return URL::cdn($src);
        }
        
        // Generate WebP version if supported
        if (strpos(request()->header('Accept'), 'image/webp') !== false) {
            return $this->convertToWebP($src);
        }
        
        return $src;
    }

    private function convertToWebP($src)
    {
        $webpPath = 'cache/images/' . md5($src) . '.webp';
        
        if (!file_exists(public_path($webpPath))) {
            $image = \Image::make(public_path($src));
            $image->encode('webp', config('performance.images.quality'));
            $image->save(public_path($webpPath));
        }
        
        return asset($webpPath);
    }
}
