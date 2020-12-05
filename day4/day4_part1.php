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
    if (isset($passport['byr']) && isset($passport['iyr']) && isset($passport['eyr']) && isset($passport['hgt']) && isset($passport['hcl']) && isset($passport['ecl']) && isset($passport['pid'])) {
        $valid = true;
    }
    if ($valid) {
        $validPassports[] = $passport;
    }
}

echo count($validPassports);
