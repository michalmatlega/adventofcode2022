<?php

function getFileContentByLines(string $filename): iterable {
    $file = fopen($filename, 'rb');
    while (($line = fgets($file)) !== false) {
        yield $line;
    }
    fclose($file);
}

const ROCK = 'rock';
const PAPER = 'paper';
const SCISSORS = 'scissors';
const LOSS = 'loss';
const DRAW = 'draw';
const WIN = 'win';

const TRANSLATE = [
    'A' => ROCK,
    'B' => PAPER,
    'C' => SCISSORS,
    'X' => LOSS,
    'Y' => DRAW,
    'Z' => WIN,
];

const BEATMAP = [
    PAPER => ROCK,
    ROCK => SCISSORS,
    SCISSORS => PAPER,
];

const SCORE = [
    ROCK => 1,
    PAPER => 2,
    SCISSORS => 3,
];

const POINTS_FOR_WIN = 6;
const POINTS_FOR_DRAW = 3;

function getPointsForRound(string $oponentDecision, string $myDecision): int
{
    $oponentDecision = TRANSLATE[$oponentDecision];
    $myDecision = TRANSLATE[$myDecision];
    $totalScore = 0;
    if(isWin($myDecision)) {
        $totalScore += POINTS_FOR_WIN;
        $myDecision = getDecisionToWin($oponentDecision);
        $totalScore += SCORE[$myDecision];
        return $totalScore;
    }
    if(isDraw($myDecision)) {
        $totalScore += POINTS_FOR_DRAW;
        $myDecision = getDecisionToDraw($oponentDecision);
        $totalScore += SCORE[$myDecision];
        return $totalScore;
    }

    $myDecision = getDecisionToLose($oponentDecision);
    return SCORE[$myDecision];
}

function isWin(string $myDecision): bool {
    return $myDecision === WIN;
}

function isDraw(string $myDecision): bool {
    return $myDecision === DRAW;
}

function getDecisionToLose(string $oponentDecision): string{
    return BEATMAP[$oponentDecision];
}

function getDecisionToWin(string $oponentDecision): string{
    $lossMap = array_flip(BEATMAP);
    return $lossMap[$oponentDecision];
}

function getDecisionToDraw(string $oponentDecision): string {
    return $oponentDecision;
}

$totalScore = 0;

foreach(getFileContentByLines('input.txt') as $line) {
    $line = trim($line);
    [$oponentDecision, $myDecision] = explode(' ', $line);
    $totalScore += getPointsForRound($oponentDecision, $myDecision);
    echo TRANSLATE[$oponentDecision] . ' ' . TRANSLATE[$myDecision] . ' ' . getPointsForRound($oponentDecision, $myDecision) . "\n";
}

echo $totalScore;
