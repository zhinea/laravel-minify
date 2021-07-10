<?php

namespace Dyumna\Minify\Core;

class JS extends Core
{

    protected $url = 'https://javascript-minifier.com/raw';


    public function __construct($_console)
    {

        parent::__construct($_console, $this->url);
    }

}
