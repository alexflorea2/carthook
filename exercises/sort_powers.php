<?php

// Normally I would use system functions like sort() https://www.php.net/sort
// Because they are offer implementations in C or  use optimizations in Zend engine

// For demo purposes, will use Quicksort. Note that PHP sort() also uses Quicksort
// Because numbers are high, their power, eg 10.000 ^ 10.0000 would be a very large number.
// As the exercise does not stipulate that the powers must be calculated, we will sort the pairs instead (a,b)

// Otherwise we could use bcpow https://www.php.net/manual/ro/function.bcpow.php to calculate the power,
// but having an array of 10.000 items of that size would be impractical memory wise

// Average is 0.05 seconds on an intel I7 6700HQ 8core ~2.66Ghz with 16gb ram :)
// big O notation would be the one for QuickSort average Θ(n log(n))

$arr_to_sort = [];

for($i=1; $i<=10000; $i++){
    $arr_to_sort[] = [rand(100,10000),rand(100,10000)];
}

function sortPowers(array $arr)
{
    $loe = $gt = array();
    if(count($arr) < 2)
    {
        return $arr;
    }
    $pivot_key = key($arr);
    $pivot = array_shift($arr);
    foreach($arr as $val)
    {
        if($val[0] + $val[1] <= $pivot[0] + $pivot[1])
        {
            $loe[] = $val;
        }elseif ($val[0] + $val[1] > $pivot[0] + $pivot[1])
        {
            $gt[] = $val;
        }
    }
    return array_merge(sortPowers($loe),array($pivot_key=>$pivot),sortPowers($gt));

}

$time_start = microtime(true);

$sorted_array = sortPowers($arr_to_sort);

$time_end = microtime(true);
$execution_time = number_format(($time_end - $time_start),10);

echo "Unsorted array: ". json_encode($arr_to_sort) . PHP_EOL;
echo "Sorted in {$execution_time} seconds" . PHP_EOL;
echo json_encode($sorted_array);
