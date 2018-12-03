<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\BenchmarkService;

class BenchmarkServiceTest extends TestCase
{
    /**
     * Test formatting and calculating of benchmark results
     *
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

    public function testCalculateResultsFunctionMissingException()
    {
        $this->expectException(\App\Exceptions\MissingFunctionNameException::class);

        $dummy = [
            'slowSort' => [1, 6, 5],
        ];
        $functionNames = [
            'bubbleSort' => 'Bubble Sort',
            'quickSort' => 'Quick Sort',
        ];

        BenchmarkService::calculateResults(
            $dummy,
            $functionNames,
            'average',
            'asc'
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
            // Test with empty result set
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
            // Test against only a single method
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
            // Tests average ascending
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
            // Tests average descending
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
            // Tests name ascending
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
            // Texts name descending
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
            // Tests min ascending
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
            // Texts min descending
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
            // Tests max ascending
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
            // Texts max descending
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
