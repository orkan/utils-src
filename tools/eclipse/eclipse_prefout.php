<?php

/**
 * Eclipse preference export script v1.0.20191126
 * By Orkan
 *
 * Uwagi:
 * Nie da sie w ten sposob zaimportowac do Eclipse tylko wybranych linii z
 * pliku preferencji. Trzeba pewnie je podmienic w aktualnym eksporcie
 * i zaimportowac tak zmodyfikowany plik w całosci...
 *
 * To be continued...
 *
 */

// ////////////////////////////////////////////////////////////////////////////////
// Example bat file:
// @echo off
// php D:\Orkan\Localhost\help\eclipse\tools\eclipse_prefout.php %1 /instance/org.eclipse.ui.workbench/org.eclipse.egit.ui.
// pause

// ////////////////////////////////////////////////////////////////////////////////
// Debug:
// echo "\$argc: {$_SERVER['argc']}\n";
// echo "\$argv: \n";
// print_r($_SERVER['argv']);
// exit;
//
// $argc: 3
// $argv:
// Array
// (
// [0] => D:\Orkan\Localhost\help\eclipse\tools\extract_preference.php
// [1] => D:\Orkan\Localhost\help\eclipse\theme\[eclipse - preferences] git colors for dark theme.epf
// [2] => /instance/org.eclipse.ui.workbench/org.eclipse.egit.ui.
// )
const PREFOUT_EXIT_SUCCESS = 0;

const PREFOUT_EXIT_FAILURE = 1;

// Define some colors for display.
const PREFOUT_COLOR_PASS = 32;

// A nice calming green.
const PREFOUT_COLOR_FAIL = 31;

// An alerting Red.
const PREFOUT_COLOR_INFO = 36; // Cyan

// //////////////////////////////////////////////////////////////////////////////////////////
// START START START START START START START START START START START START START START START
// //////////////////////////////////////////////////////////////////////////////////////////

// Validate args
$args = prefout_parse_args();
prefout_print("Welcome to Eclipse preference export script" . PHP_EOL, PREFOUT_COLOR_INFO);

// https://www.php.net/manual/en/function.file.php
$file = file($args['file'], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$lines = [];
$extras = [];

// Find all lines starting with needle
foreach ($file as $line) {
    if (0 === substr_compare($line, $args['needle'], 0, $args['needle_len'], true))
        $lines[] = $line;

//    if ($line[0] == "@")
//        $extras[] = $line;
}

// Add extra info from original file
//$lines_out = array_merge(array_slice($file, 0, 2), $lines, $extras, array($file[count($file) - 1));

// Save to new file
if (false === file_put_contents($args['file_out'], implode(PHP_EOL, $lines))) {
    prefout_error("Can't write to '{$args['file_out']}'");
    prefout_exit(PREFOUT_EXIT_FAILURE);
}

prefout_print("Found " . count($lines) . " lines for '{$args['needle']}'" . PHP_EOL, PREFOUT_COLOR_INFO);
prefout_print(print_r($lines, true) . PHP_EOL, PREFOUT_COLOR_PASS);
prefout_print("Saving to '{$args['file_out']}'" . PHP_EOL, PREFOUT_COLOR_INFO);

// //////////////////////////////////////////////////////////////////////////////////////////
// END END END END END END END END END END END END END END END END END END END END END END
// //////////////////////////////////////////////////////////////////////////////////////////

/**
 * Parse execution argument and ensure that all are valid.
 *
 * @return array The list of arguments.
 */
function prefout_parse_args()
{
    // Set default values.
    $args = [
        'color' => ! TRUE,
        'script' => basename($_SERVER['argv'][0]),
        'file' => '',
        'needle' => ''
    ];

    if (count($_SERVER['argv']) < 3) {
        prefout_error("To few arguments");
        prefout_exit(PREFOUT_EXIT_FAILURE);
    }

    if (! file_exists($_SERVER['argv'][1])) {
        prefout_error("Can't find file '{$_SERVER['argv'][1]}'");
        prefout_exit(PREFOUT_EXIT_FAILURE);
    }
    $args['file'] = $_SERVER['argv'][1];
    $args['file_out'] = preg_replace('/(\.[^.]+)$/', sprintf('%s$1', "_out"), $args['file']);

    if (empty($_SERVER['argv'][2])) {
        prefout_error("No needle specified");
        prefout_exit(PREFOUT_EXIT_FAILURE);
    }
    $args['needle'] = $_SERVER['argv'][2];
    $args['needle_len'] = strlen($_SERVER['argv'][2]);

    return $args;
}

/**
 * Exit gracefully.
 */
function prefout_exit($code = PREFOUT_EXIT_SUCCESS)
{
    if ($code != PREFOUT_EXIT_SUCCESS)
        prefout_help();

    exit($code);
}

/**
 * Print help text.
 */
function prefout_help()
{
    global $args;

    echo <<<EOF

Export lines from Eclipse preference file using a given prefix

Usage:        {$args['script']} <preference file> <line prefix>
Example:      {$args['script']} file.epf path/to/preference.ui.*


EOF;
}

/**
 * Print error messages so the user will notice them.
 *
 * Print error message prefixed with " ERROR: " and displayed in fail color if
 * color output is enabled.
 *
 * @param string $message
 *            The message to print.
 */
function prefout_error($message)
{
    prefout_print("  ERROR: $message\n", PREFOUT_COLOR_FAIL);
}

/**
 * Print a message to the console, using a color.
 *
 * @param string $message
 *            The message to print.
 * @param int $color_code
 *            The color code to use for coloring.
 */
function prefout_print($message, $color_code)
{
    global $args;
    if ($args['color']) {
        echo "\033[" . $color_code . "m" . $message . "\033[0m";
    } else {
        echo $message;
    }
}
