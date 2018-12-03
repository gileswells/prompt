<?php

namespace App\Services;

class BenchmarkService {

    /**
     * Process the requested function the requested number of times
     *
     * @param  \Callable $function Function to be tested
     * @param  integer   $count    Number of times to test
     *
     * @return array
     */
    public static function run(callable $function, $params, $count)
    {
        $output = [];
        for ($i = 0; $i < $count; $i ++) {
            $start = microtime(true);
            $function($params);
            $end = microtime(true);

            $output[] = ($end - $start) * 1000;
        }

        return $output;
    }

    /**
     * Take in the benchmark raw data and format the data in a more logical format
     *
     * @param  array $result Raw result data from to be calculated and compared
     *
     * @return [type]
     */
    public static function calculateResults(array $results, $sort = 'average', $direction = 'asc')
    {
        if (empty($results)) {
            return [];
        }

        $calculated = [];
        foreach ($results as $key => $values) {
            $calculated[$key] = [
                'min' => min($values),
                'max' => max($values),
                'average' => array_sum($values) / count($values),
            ];
        }

        return $calculated;
    }
}
