<?php

return [
    'default_quality' => 85,
    'formats' => ['webp', 'jpg', 'png'],
    'sizes' => [
        'thumbnail' => [
            'width' => 150,
            'height' => 150
        ],
        'medium' => [
            'width' => 800,
            'height' => null // Keep aspect ratio
        ],
        'large' => [
            'width' => 1920,
            'height' => null // Keep aspect ratio
        ]
    ],
    'optimize' => [
        'jpeg' => [
            'quality' => 85,
            'progressive' => true
        ],
        'png' => [
            'quality' => 85,
            'compression' => 9
        ],
        'webp' => [
            'quality' => 85
        ]
    ]
];
