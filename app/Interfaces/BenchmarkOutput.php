<?php

namespace App\Interfaces;

use App\Console\Commands\RunBenchmarks;

interface BenchmarkOutput {
    public function output(
        RunBenchmarks $benchmark,
        array $calculated,
        array $functions,
        $count,
        $sort,
        $direction
    ) : RunBenchmarks;
}
