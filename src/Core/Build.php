<?php

namespace Dyumna\Minify\Core;

use Dyumna\Minify\Support\Finder;
use Illuminate\Console\Command;

class Build extends Command
{
    /**
     * The instance console
     */
    protected $console;

    private $url = 'https://javascript-minifier.com/raw';


    public function __construct($_console)
    {
        $this->console = $_console;
    }


    /**
     * Handle Minify
     */
    public function handle()
    {
        $this->console->info('✨Looking .css and .js file in ' . config('minify.base_path') . ' 🔎');

        $finder = new Finder();

        $files = (array) $finder->search('js', 'css');
        $this->console->newLine();

        if (count($files) === 0) {
            $this->console->line('✨No Javascript or CSS file✨');
            return;
        }

        $response = $this->minifyFiles($files);

        $this->console->newLine(2);
        $failed_jobs = [
            'js' => 0,
            'css' => 0,
        ];
        $success_jobs = [
            'js' => 0,
            'css' => 0,
        ];

        foreach ($response as $res) {
            $ext = $this->getExt($res->path);
            
            if (!$res->status) {
                $failed_jobs[$ext]++;

                $this->console->info('[FAIL] ' . $res->path);
                continue;
            }

            $success_jobs[$ext]++;
            $this->console->info('[SUCCESS] ' . $res->path);
        }

        $this->console->newLine(2);
        
        $this->console->table([
            'EXT', 'Failed', 'Success'
        ], [
            [
                'CSS',
                $failed_jobs['css'],
                $success_jobs['css']
            ],
            [
                'JS',
                $failed_jobs['js'],
                $success_jobs['js']
            ]
        ]);
    }


    public function minifyFiles(array $files)
    {
        $bar = $this->console->output->createProgressBar(count($files));

        $bar->start();

        $jobs = [];

        foreach ($files as $key => $filename) {
            $response = (new Minify())->minify($filename, $this->url);

            $jobs[] = $response;

            $bar->advance();
        }

        $bar->finish();

        return $jobs;
    }

    public function getExt($path)
    {
        $temp_arr_filename = explode('/', $path);
        $filename = end($temp_arr_filename);
        $temp_arr_ext = explode('.', $filename);

        return end($temp_arr_ext);
    }
}
