<?php

namespace App\Factories;

use App\Interfaces\BenchmarkOutput;
use App\Console\Commands\RunBenchmarks;

class BenchmarkCsvOutput implements BenchmarkOutput {
    /**
     * @param  RunBenchmarks $benchmark  Console command to allow for text output to stdin
     * @param  array         $calculated Processed data ready for output
     * @param  array         $functions  Function names that were included in the results
     * @param  integer       $count      Number of passes over the tested functions
     * @param  string        $sort       Which field data was sorted by
     * @param  string        $direction  Which sorting direction was used
     *
     * @return RunBenchmarks
     */
    public function output(
        RunBenchmarks $benchmark,
        array $calculated,
        array $functions,
        $count,
        $sort,
        $direction
    ) : RunBenchmarks {
        $fh = fopen('results.csv', 'w+');
        fputcsv($fh, ['function', 'min', 'max', 'average']);
        foreach ($calculated as $row) {
            fputcsv($fh, $row);
        }
        fclose($fh);

        $benchmark->info('Data outputted to results.csv');

        return $benchmark;
    }
}