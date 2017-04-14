<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$GLOBALS['dsn']['db'] = 'mysql:host=localhost;dbname=eng_word';
$GLOBALS['dsn']['user'] = 'root';
$GLOBALS['dsn']['password'] = '';

$GLOBALS['devIPs'] = ['212.90.184.66'];

include_once "local.php";