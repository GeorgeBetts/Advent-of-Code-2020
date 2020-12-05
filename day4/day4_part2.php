<?php
$values = file_get_contents('input.txt');

$values = str_replace(' ', ',', $values);
$values = str_replace("\r\n", ',', $values);

$passportKey = 0;
$passports = [];

$passportRecords = explode(',', $values);

foreach ($passportRecords as $line) {
    if ($line) {
        $lineVals = explode(':', $line);
        $passports[$passportKey][$lineVals[0]] = $lineVals[1];
    } else {
        //blank line - new passport
        $passportKey++;
    }
}

$validPassports = [];
foreach ($passports as $passport) {
    $valid = false;
    //Birth Year
    $byrValid = false;
    if (isset($passport['byr']) && (intval($passport['byr'] >= 1920 && $passport['byr'] <= 2002))) {
        $byrValid = true;
    }
    //Issue Year
    $iyrValid = false;
    if (isset($passport['iyr']) && (intval($passport['iyr'] >= 2010 && $passport['iyr'] <= 2020))) {
        $iyrValid = true;
    }
    //Expiration Year
    $eyrValid = false;
    if (isset($passport['eyr']) && (intval($passport['eyr'] >= 2020 && $passport['eyr'] <= 2030))) {
        $eyrValid = true;
    }
    //Height
    $hgtValid = false;
    if (isset($passport['hgt'])) {
        $metric = substr($passport['hgt'], -2);
        if ($metric == 'cm') {
            $hgtValid = (intval($passport['hgt']) >= 150 and intval($passport['hgt']) <= 193) ? true : false;
        } else {
            $hgtValid = (intval($passport['hgt']) >= 59 and intval($passport['hgt']) <= 76) ? true : false;
        }
    }
    //Hair Color
    $hclValid = false;
    if (isset($passport['hcl'])) {
        if ($passport['hcl'][0] == '#') {
            $hclValid = (strlen(substr($passport['hcl'], 1)) == 6 && ctype_xdigit(substr($passport['hcl'], 1))) ? true : false;
        }
    }
    //Eye Color
    $eclValid = false;
    if (isset($passport['ecl'])) {
        switch ($passport['ecl']) {
            case 'amb':
            case 'blu':
            case 'brn':
            case 'gry':
            case 'grn':
            case 'hzl':
            case 'oth':
                $eclValid = true;
                break;
            default:
                break;
        }
    }
    //PID
    $pidValid = false;
    if (isset($passport['pid'])) {
        $pidValid = ((strlen($passport['pid']) == 9) && is_numeric($passport['pid'])) ? true : false;
    }
    if ($byrValid && $iyrValid && $eyrValid && $hgtValid && $hclValid && $eclValid && $pidValid) {
        $valid = true;
    }
    if ($valid) {
        $validPassports[] = $passport;
    }
}

echo count($validPassports);
