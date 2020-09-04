<?php

// For small arrays Insertion sort, average O(n^2), should be faster.
// After documentation, I found that sorting networks https://en.wikipedia.org/wiki/Sorting_network may be faster on average - for small number of items
// PHP might not be best though because it cannot sort in parallel

// Bellow is such a network
// it's average execution time is 0.00001 seconds
// It's complexity is constant as 35 comparisons are always made, but moving items in array can be fewer.
// so for 1 billion calculations the average would be ~10000 seconds on an intel I7 6700HQ 8core ~2.66Ghz with 16gb ram :)

$arr_to_sort = [];

for($i=1; $i<=11; $i++){
    $arr_to_sort[] = rand(1,99);
}

$sorting_network = [
    [0,1],[2,3],[4,5],[6,7],[8,9],
    [1,3],[5,7],[0,2],[4,6],[8,10],
    [1,2],[5,6],[9,10],[0,4],[3,7],
    [1,5],[6,10],[4,8],
    [5,9],[2,6],[0,4],[3,8],
    [1,5],[6,10],[2,3],[8,9],
    [1,4],[7,10],[3,5],[6,8],
    [2,4],[7,9],[5,6],
    [3,4],[7,8]
];


function sort11(array $arr, array $sorting_network)
{
    foreach($sorting_network as $pair){

        $p0 = $pair[0];
        $p1 = $pair[1];

        if( $arr[$p0] > $arr[$p1] )
        {
            $tmp = $arr[$p0];
            $arr[$p0] = $arr[$p1];
            $arr[$p1] = $tmp;
        }
    }

    return $arr;

}

$time_start = microtime(true);

$sorted_array = sort11($arr_to_sort, $sorting_network);

$time_end = microtime(true);
$execution_time = number_format(($time_end - $time_start),10);

echo "Unsorted array: ". json_encode($arr_to_sort) . PHP_EOL;
echo "Sorted in {$execution_time} seconds" . PHP_EOL;
echo json_encode($sorted_array);


