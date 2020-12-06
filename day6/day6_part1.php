<?php
$values = file_get_contents('input.txt');

$values = str_replace(' ', ',', $values);
$values = str_replace("\r\n", ',', $values);

$formKey = 0;
$forms = [];

$formRecords = explode(',', $values);

$totalQuestionCount = 0;

$forms[$formKey] = "";
foreach ($formRecords as $key => $line) {
    if ($line) {
        $forms[$formKey] .= $line;
        if ($key == array_key_last($formRecords)) {
            $formChars = str_split($forms[$formKey]);
            $totalQuestionCount += count(array_unique($formChars));
        }
    } else {
        //blank line - new form
        //first remove duplicates from form and count the total
        $formChars = str_split($forms[$formKey]);
        $totalQuestionCount += count(array_unique($formChars));
        //generate new form
        $formKey++;
        $forms[$formKey] = "";
    }
}

echo $totalQuestionCount;
