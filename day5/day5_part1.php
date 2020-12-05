<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);

$rowRange = [0, 127];
$colRange = [0, 7];
$passes = [];

foreach ($values as $line) {
    $pass = new BoardingPass();
    $pass->passId = $line;
    $pass->row = $pass->calculateRow($rowRange);
    $pass->col = $pass->calculateCol($colRange);
    $pass->seatId = $pass->calculateSeatId();
    $passes[] = $pass;
}

echo max(array_column($passes, 'seatId'));

class BoardingPass
{

    public $passId;
    public $row;
    public $col;
    public $seatId;

    public function upperHalf($range)
    {
        $rangeVal = ($range[1] - $range[0]) + 1;
        return [$range[0] + ($rangeVal / 2), $range[1]];
    }

    public function lowerHalf($range)
    {
        $rangeVal = ($range[1] - $range[0]) + 1;
        return [$range[0], $range[1] - ($rangeVal / 2)];
    }

    public function calculateRow($rowRange)
    {
        $rowString = substr($this->passId, 0, 7);
        $rowInstruction = str_split($rowString);
        $range = $rowRange;
        foreach ($rowInstruction as $letter) {
            if ($letter == 'F') { //Pay Respects
                $range = $this->lowerHalf($range);
            } else {
                $range = $this->upperHalf($range);
            }
        }
        return $range[0];
    }

    public function calculateCol($colRange)
    {
        $colString = substr($this->passId, 7);
        $colInstruction = str_split($colString);
        $range = $colRange;
        foreach ($colInstruction as $letter) {
            if ($letter == 'L') { //Gonna take the L on this one
                $range = $this->lowerHalf($range);
            } else {
                $range = $this->upperHalf($range);
            }
        }
        return $range[0];
    }

    public function calculateSeatId()
    {
        return $this->row * 8 + $this->col;
    }

}
