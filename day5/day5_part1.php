<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);

$rowRange = [0, 127];
$colRange = [0, 7];
$passes = [];

foreach ($values as $line) {
    $pass = new BoardingPass($line, $rowRange, $colRange);
    $passes[] = $pass;
}

echo max(array_column($passes, 'seatId'));

class BoardingPass
{

    public $passId;
    public $row;
    public $col;
    public $seatId;

    public function __construct($passId, $rowRange, $colRange)
    {
        $this->passId = $passId;
        $this->setRow($rowRange);
        $this->setCol($colRange);
        $this->setSeatId();
    }

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

    public function setRow($rowRange)
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
        $this->row = $range[0];
    }

    public function setCol($colRange)
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
        $this->col = $range[0];
    }

    public function setSeatId()
    {
        $this->seatId = $this->row * 8 + $this->col;
    }

}
