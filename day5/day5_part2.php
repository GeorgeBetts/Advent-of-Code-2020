<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);

$rowRange = [0, 127];
$colRange = [0, 7];
$passes = [];

foreach ($values as $line) {
    $pass = new BoardingPass($line, $rowRange, $colRange);
    $passes[] = $pass;
}

$seatIds = array_map(function ($pass) {
    return $pass->getSeatId();
}, $passes);

$maxSeatId = max($seatIds);
$minSeatId = min($seatIds);

for ($i = $minSeatId + 1; $i < $maxSeatId; $i++) {
    if (!in_array($i, $seatIds)) {
        //Value is missing - could be our seat
        if (in_array($i - 1, $seatIds) && in_array($i + 1, $seatIds)) {
            //It's my seat!
            echo $i;
            die();
        }
    }
}

class BoardingPass
{

    private $passId;
    private $row;
    private $col;
    private $seatId;

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

    public function getRow()
    {
        return $this->row;
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

    public function getCol()
    {
        return $this->col;
    }

    public function setSeatId()
    {
        $this->seatId = $this->row * 8 + $this->col;
    }

    public function getSeatId()
    {
        return $this->seatId;
    }
}
