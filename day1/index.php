<?php

function getFileContentByLines(string $filename): iterable {
    $file = fopen($filename, 'rb');
    while (($line = fgets($file)) !== false) {
        yield $line;
    }
    fclose($file);
}

$totalCalories = [];
$localMax = 0;
foreach(getFileContentByLines('input.txt') as $line) {
    if($singleValue = (int)$line) {
        $localMax += $singleValue;
    } else {
        $totalCalories[] = $localMax;
        $localMax = 0;
    }
}

sort($totalCalories);
$totalCalories = array_reverse($totalCalories);

echo $totalCalories[0] + $totalCalories[1] + $totalCalories[2];


