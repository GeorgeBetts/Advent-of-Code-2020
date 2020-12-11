<?php

//Read in values and convert to integers
$values = array_map(function ($value) {
    return intval($value);
}, file('input.txt', FILE_IGNORE_NEW_LINES));

//Add in start and end adapters
$values[] = 0;
sort($values);
$values[] = $values[count($values) - 1] + 3;

//First, create an array of how many nodes could come next in sequence
$sequenceCount = [];
foreach ($values as $key => $adapter) {
    $possibleNextAdapterCount = 0;
    if (isset($values[$key + 1]) && $values[$key + 1] <= $adapter + 3) {
        $possibleNextAdapterCount++;
        if (isset($values[$key + 2]) && $values[$key + 2] <= $adapter + 3) {
            $possibleNextAdapterCount++;
            if (isset($values[$key + 3]) && $values[$key + 3] <= $adapter + 3) {
                $possibleNextAdapterCount++;
            }
        }
    }
    $sequenceCount[] = $possibleNextAdapterCount;
}

//Remove any garunteed nodes
$divergentNodes = [];
$curDivergCount = 0;
foreach ($sequenceCount as $key => $value) {
    //Next node is not garunteed if it's skippable
    if ($key >= 1) {
        if ($sequenceCount[$key - 1] > 1) {
            $curDivergCount++;
        } else {
            if ($curDivergCount > 0) {
                $divergentNodes[] = $curDivergCount;
            }
            $curDivergCount = 0;
        }
    }
}

//For each place the nodes can split, multiply the possibilties by all previous potential splits
$totalSorts = 0;
foreach ($divergentNodes as $key => $divergentCount) {
    $rangeSum = array_sum(range(1, $divergentCount));
    if ($key == 0) {
        $totalSorts += $rangeSum;
    } else {
        $totalSorts += $rangeSum + ($rangeSum * $totalSorts);
    }
}

echo $totalSorts + 1;
