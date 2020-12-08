<?php
$instructions = file('input.txt', FILE_IGNORE_NEW_LINES);

$accumulator = 0;
$key = 0;
$completedInstructions = [];
$modifiedInstructions = [];
$modifiedThisIteration = false;
$finished = false;

while ($finished == false) {
    //Attempted instruction is greater than the max key so it's reached the end of the program
    if ($key >= count($instructions)) {
        $finished = true;
    }
    if (!in_array($key, $completedInstructions)) {
        $completedInstructions[] = $key;
        $task = substr($instructions[$key], 0, 3);
        preg_match('/[+-][0-9]+/', $instructions[$key], $matches);
        $increment = $matches[0];
        //If this particular jmp or nop instruction has not been modified yet, then attempt to change this one
        if (!in_array($key, $modifiedInstructions) && !$modifiedThisIteration) {
            if ($task == 'jmp') {
                $task = 'nop';
                $modifiedInstructions[] = $key;
                $modifiedThisIteration = true;
            } elseif ($task == 'nop') {
                $task = 'jmp';
                $modifiedInstructions[] = $key;
                $modifiedThisIteration = true;
            }
        }
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
        //didn't work start again
        $accumulator = 0;
        $key = 0;
        $modifiedThisIteration = false;
        $completedInstructions = [];
    }
}

echo $accumulator;
