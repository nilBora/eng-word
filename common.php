<?php
if (!session_id()) {
	session_start();
}
define('ROOT_DIR', __DIR__.'/');
define('COMMON_DIR', ROOT_DIR.'Common/');
define('CORE_DIR', COMMON_DIR.'core/');
define('MODULES_DIR', COMMON_DIR.'modules/');
define('TEMPLATE_DIR', ROOT_DIR.'templates/');
define('THEME_DIR', ROOT_DIR.'theme/');
define('HELPERS_DIR', CORE_DIR.'helpers/');


//Перенести в вайл Autoload.php c core dir
require_once "config.php";
require_once CORE_DIR."autoload.php";


$db = new PDO(
    $GLOBALS['dsn']['db'],
    $GLOBALS['dsn']['user'],
    $GLOBALS['dsn']['password']
);

$core = Nil\Common\Core\Core::getInstance();
$core->db = Nil\DB\Object::factory($db);

