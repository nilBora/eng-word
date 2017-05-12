<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$GLOBALS['dsn']['db'] = 'mysql:host=localhost;dbname=eng_word';
$GLOBALS['dsn']['user'] = 'root';
$GLOBALS['dsn']['password'] = '';

$GLOBALS['dev']['IPs'] = ['212.90.184.66', '188.190.236.51', '127.0.0.1'];
$GLOBALS['dev']['profiler'] = true;

include_once "local.php";