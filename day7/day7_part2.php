<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);

$bags = [];

foreach ($values as $key => $line) {
    $explodeLine = explode("contain", $line);
    $colour = removeBagFromString($explodeLine[0]);
    $existingBag = getBagByColour($bags, $colour);
    if ($existingBag) {
        $existingBag->calculateCanContain($explodeLine[1], $bags);
    } else {
        $bag = createBagAndAddToBags($bags, $colour);
        $bag->calculateCanContain($explodeLine[1], $bags);
    }
}

//echo json_encode($bags);

echo countNestedBags(getBagByColour($bags, 'shiny gold'), $bags);

function countNestedBags($bag, $bags)
{
    $totalCount = 0;
    foreach ($bag->canContain as $subBag) {
        $totalCount += $subBag->number + $subBag->number * countNestedBags($subBag->bag, $bags);
    }
    return $totalCount;
}

function countPossibleBags($colour, $bags)
{
    $count = 0;
    foreach ($bags as $bag) {
        if (canBagContain($bag, $colour)) {
            $count++;
        }
    }
    return $count;
}

function canBagContain($bag, $colour)
{
    foreach ($bag->canContain as $value) {
        $subBag = $value->bag;
        if ($subBag->colour == $colour) {
            return true;
        } elseif (count($subBag->canContain) > 0) {
            if (canBagContain($subBag, $colour)) {
                return true;
            }
        }
    }
}

class Bag
{

    public $colour;
    public $canContain;

    public function __construct($colour)
    {
        $this->colour = $colour;
    }

    public function calculateCanContain($contents, &$bags)
    {
        if ($contents != " no other bags.") {
            $colours = array_map(function ($bag) use (&$bags) {
                $bagColour = removeBagFromString(substr($bag, 2));
                $existingBag = getBagByColour($bags, $bagColour);
                return (object) [
                    'number' => intval($bag),
                    'bag' => $existingBag ? $existingBag : createBagAndAddToBags($bags, $bagColour),
                ];
            }, explode(",", trim(rtrim($contents, '.'))));
        } else {
            $colours = [];
        }
        $this->canContain = $colours;
    }

}

function createBagAndAddToBags(&$bags, $colour)
{
    $bag = new Bag($colour);
    $bags[] = $bag;
    return $bag;
}

function removeBagFromString($string)
{
    // return rtrim(rtrim(trim($string), ' bags'), 'bag');
    return preg_replace('/\W\w+\s*(\W*)$/', '$1', trim($string));
}

//Returns the bag, or returns false if no bag was found
function getBagByColour($bags, $colour)
{
    foreach ($bags as $bag) {
        if ($bag->colour == $colour) {
            return $bag;
        }
    }
    return false;
}
