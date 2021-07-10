<?php

namespace Dyumna\Minify\Core;

class CSS extends Core
{

    protected $url = 'https://cssminifier.com/raw';


    public function __construct($_console)
    {

        parent::__construct($_console, $this->url);
    }

}
