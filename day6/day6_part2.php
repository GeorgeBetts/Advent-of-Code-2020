<?php
$values = file_get_contents('input.txt');

$values = str_replace(' ', ',', $values);
$values = str_replace("\r\n", ',', $values);

$formKey = 0;
$forms = [];

$formRecords = explode(',', $values);

$totalQuestionCount = 0;

$forms[$formKey]['responses'] = "";
foreach ($formRecords as $key => $line) {
    if ($line) {
        $forms[$formKey]['people'][] = $line;
        $forms[$formKey]['responses'] .= $line;
    } else {
        //blank line - new form
        $formKey++;
        $forms[$formKey]['responses'] = "";
    }
}

foreach ($forms as $form) {
    //All the questions this group answered
    $chars = array_unique(str_split($form['responses']));
    //If it's only one person in the group we can avoid doing all the checks
    if (count($form['people']) == 1) {
        $totalQuestionCount += count($chars);
    } else {
        if ($form['responses']) {
            foreach ($chars as $char) {
                $allAnswered = true;
                foreach ($form['people'] as $person) {
                    if (strpos($person, $char) === false) {
                        //This person did not answer the question
                        $allAnswered = false;
                        break;
                    }
                }
                //They all answered this question so it counts
                $totalQuestionCount += $allAnswered ? 1 : 0;
            }
        }
    }
}

echo $totalQuestionCount;
