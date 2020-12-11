<?php

$values = file('input.txt', FILE_IGNORE_NEW_LINES);

$values = array_map(function ($value) {
    return intval($value);
}, $values);

$values[] = 0;

sort($values);

$values[] = $values[count($values) - 1] + 3;

$singleJoltDifferences = 0;
$tripleJoltDifferences = 0;

foreach ($values as $key => $adapter) {
    if ($key != 0) {
        if ($adapter == ($values[$key - 1] + 1)) {
            $singleJoltDifferences++;
        }
        if ($adapter == ($values[$key - 1] + 3)) {
            $tripleJoltDifferences++;
        }
    }
}

echo $singleJoltDifferences . " * " . $tripleJoltDifferences . " = " . $singleJoltDifferences * $tripleJoltDifferences;
