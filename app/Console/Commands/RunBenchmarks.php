<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BenchmarkService;
use App\Factories\BenchmarkOutputFactory;

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
     * Array of human readable method names
     * @var array
     */
    protected $functionNames = [
        'bubbleSort' => 'Bubble Sort',
        'quickSort' => 'Quick Sort',
    ];

    /**
     * Array of 1000 items to give more time to make sorting easier on the eye to see
     * @var array
     */
    protected $dummyArray = [
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4, 3, 3, 3, 13, 55, 65, 66, 82, 97, 87, 19, 71,
        1, 3, 5, 10, 22, 11, 32, 15, 5, 4,
    ];

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

        $results = [];

        foreach ($functions as $func) {
            // @TODO move this into a factory vs testing methods only off of this class
            $testResult = BenchmarkService::run(
                [$this, $func],
                $this->dummyArray,
                $count
            );

            $results[$func] = $testResult;
        }

        $sort = $this->choice('How would you like the results sorted?', ['average', 'min', 'max'], 0);
        $direction = $this->choice('How would you like the results ordered?', ['asc', 'desc'], 0);

        $calculated = BenchmarkService::calculateResults($results, $this->functionNames, $sort, $direction);

        $outputType = $this->choice('What output format would you like?', ['print', 'csv'], 0);
        $outputFactory = BenchmarkOutputFactory::getFactory($outputType);
        $outputFactory->output($this, $calculated, $functions, $count, $sort, $direction);
    }

    /**
     * Original method from https://github.com/mookofe/php-benchmark
     *
     * @return void
     */
    public function bubbleSort($array)
    {
        if (!$length = count($array)) {
            return $array;
        }

        for ($outer = 0; $outer < $length; $outer++) {
            for ($inner = 0; $inner < $length; $inner++) {
                if ($array[$outer] < $array[$inner]) {
                    $tmp = $array[$outer];
                    $array[$outer] = $array[$inner];
                    $array[$inner] = $tmp;
                }
            }
        }
    }

    /**
     * Original method from https://github.com/mookofe/php-benchmark
     *
     * @return void
     */
    public function quickSort($array)
    {
        if (!$length = count($array)) {
            return $array;
        }

        $k = $array[0];
        $x = $y = array();

        for ($i=1;$i<$length;$i++) {
            if ($array[$i] <= $k) {
                $x[] = $array[$i];
            } else {
               $y[] = $array[$i];
            }
        }
        return array_merge($this->quickSort($x),array($k),$this->quickSort($y));
    }
}
