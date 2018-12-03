<?php

namespace App\Factories;

class BenchmarkOutputFactory {
    /**
     * @param  string $type Output type
     *
     * @return BenchmarkOutput
     */
    public static function getFactory ($type) {
        switch ($type) {
            case 'print':
                return new BenchmarkPrintOutput();
            case 'csv':
                return new BenchmarkCsvOutput();
            default:
                throw new \Exception('Invalid output type');
        }
    }
}
