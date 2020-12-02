<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);
$target = 2020;
foreach ($values as $value) {
    foreach ($values as $value2) {
        foreach ($values as $value3) {
            if (intval($value) + intval($value2) + intval($value3) == $target) {
                echo "result: " . $value * $value2 * $value3;
                die();
            }
        }
    }
}
