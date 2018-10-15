<?php

$testDIR = __DIR__;

define('TESTS_DIR', "{$testDIR}");
define('COMPOSER_AUTOLOAD_FILE_PATH', "{$testDIR}/../vendor/autoload.php");

require COMPOSER_AUTOLOAD_FILE_PATH;
