<?php

namespace Dyumna\Minify\Core;

use Dyumna\Minify\Support\Finder;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Core extends Command
{
    /**
     * The instance console
     */
    protected $console;

    // private $url = 'https://javascript-minifier.com/raw';


    public function __construct($_console, $url)
    {
        $this->console = $_console;
    }

    public function className()
    {
        return class_basename($this);
    }

    /**
     * Handle Minify
     */
    public function handle()
    {
        $this->console->info('✨Looking .' . $this->className() . ' in ' . config('minify.base_path') . ' 🔎');

        $finder = new Finder();

        $files = (array) $finder->search(Str::lower($this->className()));
        $this->console->newLine();

        if (count($files) === 0) {
            $this->console->line('✨No '. $this->className() .' file✨');
            return;
        }

        $response = $this->minifyFiles($files);

        $this->console->newLine(2);
        $failed_jobs = 0;
        $success_jobs = 0;

        foreach ($response as $res) {
            if (!$res->status) {
                $failed_jobs++;
                $this->console->info('[FAIL] ' . $res->path);
                continue;
            }

            $this->console->info('[SUCCESS] ' . $res->path);
            $success_jobs++;
        }

        $this->console->newLine(2);
        $this->console->table([
            'Failed', 'Success'
        ], [
            [
                $failed_jobs,
                $success_jobs
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
}
