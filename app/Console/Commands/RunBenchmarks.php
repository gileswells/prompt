<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunBenchmarks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:benchmarks {--func=*} {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run benchmarks for specified commands using an existing library';

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
     * @return mixed
     */
    public function handle()
    {
        $functions = $this->option('func');
        $count = $this->argument('count');

        $r = new \ReflectionFunction('in_array');
        $params = $r->getParameters();
        foreach ($params as $param) {
            echo $param->getName()."\n";
            echo ($param->isOptional() === false) ? "no\n" : "yes\n";
            echo ($param->isArray() === false) ? "no\n" : "yes\n";
        }
    }
}
