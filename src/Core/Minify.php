<?php

namespace Dyumna\Minify\Core;

use \File;
use Dyumna\Minify\Support\Request;

class Minify
{
    public $urls = [
        'js' => 'https://javascript-minifier.com/raw',
        'css' => 'https://cssminifier.com/raw'
    ];

    public function minify(string $path, string $url)
    {
        $raw = File::get($path);

        $ext = $this->getExt($path);

        $response = $this->request($this->urls[$ext], $raw);
        
        $response['path'] = $path;

        File::put($path, $response['body']);
        File::put($path . '.' . time(), $raw);

        return (object) $response;
    }

    /**
     * Handle Request
     */
    protected function request(string $url, $raw)
    {
        return (new Request())->send($url, [ "input" => $raw]);
    }

    private function getExt($path)
    {
        $temp_arr_filename = explode('/', $path);
        $filename = end($temp_arr_filename);
        $temp_arr_ext = explode('.', $filename);

        return end($temp_arr_ext);
    }
}
