<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\BenchmarkService;

class BenchmarkServiceTest extends TestCase
{
    /**
     * @dataProvider calculateResultsDataProvider
     */
    public function testCalculateResults($expected, $results, $sort, $order)
    {
        $actual = BenchmarkService::calculateResults($results, $sort, $order);

        $this->assertEquals($expected, $actual);
    }

    /**
     * Make sure that bad data throws the expected exceptions.
     *
     * @dataProvider calculateResultsExceptionsDataProvider
     *
     * @return void
     */
    public function testCalculateResultsExceptions($exception, $sort, $order)
    {
        $this->expectException($exception);

        $dummy = [
            [
                'foo' => 'bar',
            ],
        ];

        BenchmarkService::calculateResults($dummy, $sort, $order);
    }

    /**
     * Data Provider for sorting of results
     *
     * @return array
     */
    public function calculateResultsDataProvider()
    {
        return [
            'empty-data' => [
                [],
                [],
                null,
                null,
            ],
            'average' => [
                [
                    'quickSort' => [
                        'min' => 2,
                        'max' => 4,
                        'average' => 3,
                    ],
                    'bubbleSort' => [
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                    'quickSort' => [2, 4, 3, 3],
                ],
                'average',
                'asc',
            ],
            'average-descending' => [
                [
                    'bubbleSort' => [
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                    'quickSort' => [
                        'min' => 2,
                        'max' => 4,
                        'average' => 3,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                    'quickSort' => [2, 4, 3, 3],
                ],
                'average',
                'desc',
            ],
            'min' => [
                [
                    'bubbleSort' => [
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                    'quickSort' => [
                        'min' => 2,
                        'max' => 4,
                        'average' => 3,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                    'quickSort' => [2, 4, 3, 3],
                ],
                'min',
                'asc',
            ],
            'min-descending' => [
                [
                    'quickSort' => [
                        'min' => 2,
                        'max' => 4,
                        'average' => 3,
                    ],
                    'bubbleSort' => [
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                    'quickSort' => [2, 4, 3, 3],
                ],
                'min',
                'desc',
            ],
            'max' => [
                [
                    'quickSort' => [
                        'min' => 2,
                        'max' => 4,
                        'average' => 3,
                    ],
                    'bubbleSort' => [
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                    'quickSort' => [2, 4, 3, 3],
                ],
                'max',
                'asc',
            ],
            'max-descending' => [
                [
                    'bubbleSort' => [
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                    'quickSort' => [
                        'min' => 2,
                        'max' => 4,
                        'average' => 3,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                    'quickSort' => [2, 4, 3, 3],
                ],
                'max',
                'desc',
            ],
        ];
    }

    /**
     * Data Provider to test for properly thrown Exceptions in BenchmarkService::calculateResults
     *
     * @return array
     */
    public function calculateResultsExceptionsDataProvider()
    {
        return [
            [
                \App\Exceptions\InvalidSortException::class,
                'invalid-option',
                'asc',
            ],
            [
                \App\Exceptions\InvalidOrderException::class,
                'min',
                'invalid-option',
            ],
        ];
    }
}
