<?php

$values = file('input.txt', FILE_IGNORE_NEW_LINES);
$xmasDecypter = new XmasDecrypter(25, $values);

//Part 1
$nonValidKey = $xmasDecypter->findFirstNonValidKey();
$nonValidValue = $xmasDecypter->cypher[$nonValidKey];
echo $nonValidValue;
echo "  |  ";
//Part 2
$weaknessRange = $xmasDecypter->findSumRange($nonValidValue);
echo min($weaknessRange) + max($weaknessRange);

class XmasDecrypter
{

    private $preambleLen;
    public $cypher;

    public function __construct($preambleLen, $cypher)
    {
        $this->preambleLen = $preambleLen;
        $this->cypher = $cypher;
    }

    /**
     * Returns the first non valid key in the decrypters cypher
     * returns false if all keys are valid
     *
     * @return integer
     */
    public function findFirstNonValidKey(): int
    {
        foreach ($this->cypher as $key => $value) {
            if ($key >= $this->preambleLen) {
                if (!$this->isValidKey($key, $this->calculatePossibleValues($key))) {
                    return $key;
                }
            }
        }
        return false;
    }

    /**
     * Finds which contiguous set in the cypher sums up to the target value
     * Returns the set as an array
     *
     * @params integer $target
     * @return array
     */
    public function findSumRange($target): array
    {
        foreach ($this->cypher as $key => $value) {
            $range = 2;
            while ($range <= count(array_slice($this->cypher, $key))) {
                $sequence = array_slice($this->cypher, $key, $range);
                if (array_sum($sequence) == $target) {
                    return $sequence;
                    break;
                } else {
                    $range++;
                }
            }
        }
        return false;
    }

    /**
     * Checks the previous preamble values and returns an array of all possible outcomes
     *
     * @param int $key The cypher key for which you want to find out the possible values
     * @return array
     */
    public function calculatePossibleValues($key): array
    {
        $preamble = array_slice($this->cypher, $key - $this->preambleLen, $this->preambleLen, true);
        $possibleValues = [];
        foreach ($preamble as $value) {
            $possibleValues = array_merge(array_filter(array_map(function ($subValue) use ($value) {
                if ($value != $subValue) {
                    return $value + $subValue;
                }
            }, $preamble)), $possibleValues);
        }
        return array_unique($possibleValues);
    }

    /**
     * Checks if the passed key is one of the passed possible values
     *
     * @param int $key
     * @param array $possibleValues
     * @return boolean
     */
    public function isValidKey($key, $possibleValues): int
    {
        return in_array($this->cypher[$key], $possibleValues) ? true : false;
    }

}
