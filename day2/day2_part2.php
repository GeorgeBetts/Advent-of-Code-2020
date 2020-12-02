<?php
$values = file('input.txt', FILE_IGNORE_NEW_LINES);

//First step is to loop each line in the input file and get a readable format
foreach ($values as $line) {
    //Create a password policy object with the appropriate values
    $policy = (object) [
        'pos1' => intval(trim(get_string_between($line, '', '-'))),
        'pos2' => intval(trim(get_string_between($line, '-', ' '))),
        'target' => trim(get_string_between($line, ' ', ':')),
        'password' => substr(trim(strstr($line, ': ')), 2),
    ];

    //Add the object to the array of policies so we have a readable list
    $arrPolicies[] = $policy;
}

//loop the policies and see if they pass
$accepted = [];
foreach ($arrPolicies as $policy) {
    $val1 = substr($policy->password, $policy->pos1 - 1, 1);
    $val2 = substr($policy->password, $policy->pos2 - 1, 1);
    if ($val1 == $policy->target || $val2 == $policy->target) {
        if (!($val1 == $policy->target && $val2 == $policy->target)) {
            $accepted[] = $policy;
        }
    }
}

//The result
echo count($accepted);

function get_string_between($string, $start, $end)
{
    $value = '';
    if ($start != ' ') {
        $string = ' ' . $string;
    }
    if ($start) {
        $ini = strpos($string, $start);
    } else {
        $ini = 0;
    }
    if ($ini != 0) {
        $ini += strlen($start);
    }
    $len = strpos($string, $end, $ini) - $ini;
    $value = substr($string, $ini, $len);
    return $value;
}
