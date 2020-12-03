<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);

$lineLen = strlen($values[0]);
$lineCount = count($values);
//First index of curPos is line number, second index is horizontal position
$curPos = [0, 0];
//Movement consists of a direction 0 = up, 1 = right, 2 = down, 3 = left
//and an integer to say the number of spaces to move
$movement = [[1, 3], [2, 1]];
$treeCount = 0;

while ($curPos[0] <= $lineCount) {
    $curPos = moveSkier($lineLen, $curPos, $movement);
    $line = $values[$curPos[0]];
    if (substr($line, $curPos[1], 1) == '#') {
        $treeCount++;
    }
}

echo $treeCount;

//Function returns the new position
function moveSkier($lineLen, $curPos, $movement)
{
    foreach ($movement as $instruction) {
        switch ($instruction[0]) {
            case 0: //Up
                for ($i = 0; $i < $instruction[1]; $i++) {
                    if ($curPos[0] != 0) {
                        $curPos[0]--;
                    }
                }
                break;
            case 1: //Right
                for ($i = 0; $i < $instruction[1]; $i++) {
                    if ($curPos[1] != ($lineLen - 1)) {
                        $curPos[1]++;
                    } else {
                        //We hit the end, so move the position back to the start (on the same line)
                        $curPos[1] = 0;
                    }
                }
                break;
            case 2: //Down
                for ($i = 0; $i < $instruction[1]; $i++) {
                    $curPos[0]++;
                }
                break;
            case 3: //Left
                break;
            default:
                break;
        }
    }
    return $curPos;
}
