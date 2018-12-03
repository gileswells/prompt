<?php

namespace App\Services;

class BenchmarkService {

	/**
	 * @param  \Callable $function Function to be tested
	 * @param  string    $name     Human readable function name
	 * @param  integer   $count    Number of times to test
	 *
	 * @return array
	 */
	public static function run(callable $function, $params, $name, $count)
	{
		$output = [];

		for ($i=0; $i < $count; $i++) {
			$start = microtime(true);
			$function($params);
			$end = microtime(true);

			$output[] = ($end - $start) * 1000;
		}

		return $output;
	}
}
