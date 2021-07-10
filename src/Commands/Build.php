<?php

namespace Dyumna\Minify\Commands;

use Illuminate\Console\Command;

class Build extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minify:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Minify Javascript and CSS file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        (new \Dyumna\Minify\Core\Build($this))->handle();
    }
}
