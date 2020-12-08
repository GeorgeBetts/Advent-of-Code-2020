<?php
$instructions = file('input.txt', FILE_IGNORE_NEW_LINES);

$accumulator = 0;
$key = 0;
$completedInstructions = [];
$finished = false;

while ($finished == false) {
    if (!in_array($key, $completedInstructions)) {
        $completedInstructions[] = $key;
        $task = substr($instructions[$key], 0, 3);
        preg_match('/[+-][0-9]+/', $instructions[$key], $matches);
        $increment = $matches[0];
        switch ($task) {
            case 'acc':
                $accumulator += $increment;
                $key++;
                break;
            case 'jmp':
                $key += $increment;
                break;
            case 'nop':
                $key++;
                break;
            default:
                break;
        }
    } else {
        $finished = true;
    }
}

echo $accumulator;
