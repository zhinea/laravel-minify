# laravel-minify
Simple Javascript and CSS minify


First
------------

clone this repository in your laravel project


Two
------------

add ``Dyumna\Minify\PackageServiceProvider::class,`` in app/config.php

    
    'providers' => [
        /* ... */
        
        Dyumna\Minify\PackageServiceProvider::class,
    ]
    

Three
------------

run  ``php artisan vendor:publish Dyumna\Minify\PackageServiceProvider`` on terminal you laravel project
 
 
Four
------------

``php artisan minify:js`` to minify all javascript files

``php artisan minify:css`` to minify all css files

``php artisan minify:build`` to minify all css and javascript files
