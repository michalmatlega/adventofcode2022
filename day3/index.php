<?php

function getFileContentByLines(string $filename): iterable {
    $file = fopen($filename, 'rb');
    while (($line = fgets($file)) !== false) {
        yield $line;
    }
    fclose($file);
}
