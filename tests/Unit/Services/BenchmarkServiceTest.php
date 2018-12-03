<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\BenchmarkService;

class BenchmarkServiceTest extends TestCase
{
    /**
     * A basic test example.
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
