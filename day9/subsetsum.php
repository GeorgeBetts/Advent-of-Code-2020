<?php

/**
 * Testing file to trial out subset sum methods with a smaller dataset
 */

$target = 9;
$numbers = [1, 5, 2, 3, 4, 8, 7, 6, 11, 4, 2, 3];
$results = [];

foreach ($numbers as $key => $number) {
    $range = 2;
    while ($range <= count(array_slice($numbers, $key))) {
        $sequence = array_slice($numbers, $key, $range);
        if (array_sum($sequence) == $target) {
            $results[] = $sequence;
            break;
        } else {
            $range++;
        }
    }
}

echo $results;
