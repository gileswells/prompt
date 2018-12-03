<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\BenchmarkService;

class BenchmarkServiceTest extends TestCase
{
    /**
     * @dataProvider calculateResultsDataProvider
     */
    public function testCalculateResults($expected, $results, $functionNames, $sort, $order)
    {
        $actual = BenchmarkService::calculateResults(
            $results,
            $functionNames,
            $sort,
            $order
        );

        $this->assertEquals($expected, $actual);
    }

    /**
     * Make sure that bad data throws the expected exceptions.
     *
     * @dataProvider calculateResultsExceptionsDataProvider
     *
     * @return void
     */
    public function testCalculateResultsExceptions($exception, $functionNames, $sort, $order)
    {
        $this->expectException($exception);

        $dummy = [
            [
                'foo' => 'bar',
            ],
        ];

        BenchmarkService::calculateResults(
            $dummy,
            $functionNames,
            $sort,
            $order
        );
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
                [
                    'bubbleSort' => 'Bubble Sort',
                    'quickSort' => 'Quick Sort',
                ],
                null,
                null,
            ],
            'single-function' => [
                [
                    'bubbleSort' => [
                        'name' => 'Bubble Sort',
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                ],
                [
                    'bubbleSort' => 'Bubble Sort',
                    'quickSort' => 'Quick Sort',
                ],
                'average',
                'asc',
            ],
            'average' => [
                [
                    'quickSort' => [
                        'name' => 'Quick Sort',
                        'min' => 2,
                        'max' => 4,
                        'average' => 3,
                    ],
                    'bubbleSort' => [
                        'name' => 'Bubble Sort',
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                    'quickSort' => [2, 4, 3, 3],
                ],
                [
                    'bubbleSort' => 'Bubble Sort',
                    'quickSort' => 'Quick Sort',
                ],
                'average',
                'asc',
            ],
            'average-descending' => [
                [
                    'bubbleSort' => [
                        'name' => 'Bubble Sort',
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                    'quickSort' => [
                        'name' => 'Quick Sort',
                        'min' => 2,
                        'max' => 4,
                        'average' => 3,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                    'quickSort' => [2, 4, 3, 3],
                ],
                [
                    'bubbleSort' => 'Bubble Sort',
                    'quickSort' => 'Quick Sort',
                ],
                'average',
                'desc',
            ],
            'name' => [
                [
                    'bubbleSort' => [
                        'name' => 'Bubble Sort',
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                    'quickSort' => [
                        'name' => 'Quick Sort',
                        'min' => 2,
                        'max' => 4,
                        'average' => 3,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                    'quickSort' => [2, 4, 3, 3],
                ],
                [
                    'bubbleSort' => 'Bubble Sort',
                    'quickSort' => 'Quick Sort',
                ],
                'name',
                'asc',
            ],
            'name-descending' => [
                [
                    'quickSort' => [
                        'name' => 'Quick Sort',
                        'min' => 2,
                        'max' => 4,
                        'average' => 3,
                    ],
                    'bubbleSort' => [
                        'name' => 'Bubble Sort',
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                    'quickSort' => [2, 4, 3, 3],
                ],
                [
                    'bubbleSort' => 'Bubble Sort',
                    'quickSort' => 'Quick Sort',
                ],
                'name',
                'desc',
            ],
            'min' => [
                [
                    'bubbleSort' => [
                        'name' => 'Bubble Sort',
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                    'quickSort' => [
                        'name' => 'Quick Sort',
                        'min' => 2,
                        'max' => 4,
                        'average' => 3,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                    'quickSort' => [2, 4, 3, 3],
                ],
                [
                    'bubbleSort' => 'Bubble Sort',
                    'quickSort' => 'Quick Sort',
                ],
                'min',
                'asc',
            ],
            'min-descending' => [
                [
                    'quickSort' => [
                        'name' => 'Quick Sort',
                        'min' => 2,
                        'max' => 4,
                        'average' => 3,
                    ],
                    'bubbleSort' => [
                        'name' => 'Bubble Sort',
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                    'quickSort' => [2, 4, 3, 3],
                ],
                [
                    'bubbleSort' => 'Bubble Sort',
                    'quickSort' => 'Quick Sort',
                ],
                'min',
                'desc',
            ],
            'max' => [
                [
                    'quickSort' => [
                        'name' => 'Quick Sort',
                        'min' => 2,
                        'max' => 4,
                        'average' => 3,
                    ],
                    'bubbleSort' => [
                        'name' => 'Bubble Sort',
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                    'quickSort' => [2, 4, 3, 3],
                ],
                [
                    'bubbleSort' => 'Bubble Sort',
                    'quickSort' => 'Quick Sort',
                ],
                'max',
                'asc',
            ],
            'max-descending' => [
                [
                    'bubbleSort' => [
                        'name' => 'Bubble Sort',
                        'min' => 1,
                        'max' => 6,
                        'average' => 4,
                    ],
                    'quickSort' => [
                        'name' => 'Quick Sort',
                        'min' => 2,
                        'max' => 4,
                        'average' => 3,
                    ],
                ],
                [
                    'bubbleSort' => [1, 6, 5],
                    'quickSort' => [2, 4, 3, 3],
                ],
                [
                    'bubbleSort' => 'Bubble Sort',
                    'quickSort' => 'Quick Sort',
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
                [
                    'bubbleSort' => 'Bubble Sort',
                    'quickSort' => 'Quick Sort',
                ],
                'invalid-option',
                'asc',
            ],
            [
                \App\Exceptions\InvalidOrderException::class,
                [
                    'bubbleSort' => 'Bubble Sort',
                    'quickSort' => 'Quick Sort',
                ],
                'min',
                'invalid-option',
            ],
        ];
    }
}
