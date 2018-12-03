<?php

namespace App\Services;

use App\Exceptions\InvalidSortException;
use App\Exceptions\InvalidOrderException;

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
     * @param  array  $result    Raw result data from to be calculated and compared
     * @param  string $sort      Which field to sort by
     * @param  string $direction Sort direction
     *
     * @return [type]
     */
    public static function calculateResults(array $results, $sort = 'average', $direction = 'asc')
    {
        if (empty($results)) {
            return [];
        }
        if (!in_array($sort, ['min', 'max', 'average'])) {
            throw new InvalidSortException($sort . ' is not a valid sort field');
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            throw new InvalidOrderException($direction . ' is not a valid ordering direction');
        }

        $descending = ($direction !== 'asc');

        $calculated = collect($results)
            ->map(function ($values, $key) {
                $item = [
                    'min' => min($values),
                    'max' => max($values),
                    'average' => array_sum($values) / count($values),
                ];

                return $item;
            })
            ->sortBy($sort, SORT_REGULAR, $descending)
            ->toArray();

        return $calculated;
    }
}
