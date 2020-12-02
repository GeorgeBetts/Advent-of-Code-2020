<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);
$target = 2020;
foreach ($values as $value) {
    foreach ($values as $value2) {
        if (intval($value) + intval($value2) == $target) {
            echo $value . ", " . $value2;
            echo "result: " . $value * $value2;
            die();
        }
    }
}
