<?php
$basename = basename($argv[0]);

if ( $argc < 3 ) {
	die("
Export lines from Eclipse preference file using a given prefix

Usage:        {$basename} <preference file> <line prefix>
Example:      {$basename} eclipse.epf path/to/preference.ui.

");
}

$infile = $argv[1];
$needle = $argv[2];
$length = strlen($needle);

$file = file( $infile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
foreach ($file as $line) {
    if (0 === substr_compare($line, $needle, 0, $length, true)) {
        echo $line . "\n";
	}
}
