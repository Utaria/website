<?php

use UtariaV1\Database;
use UtariaV1\Router;

ini_set('session.cookie_domain', '.utaria.fr');
session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
ini_set('memory_limit', '-1');

define('WEBROOT', dirname(__FILE__));
define('ROOT', dirname(WEBROOT));
define('DS', DIRECTORY_SEPARATOR);
define('SRC', ROOT . DS . 'src');

require SRC . DS . 'core' . DS . 'Config.php';
require SRC . DS . 'core' . DS . 'functions.php';
require SRC . DS . 'core' . DS . 'Database.php';
require SRC . DS . 'core' . DS . 'Controller.php';
require SRC . DS . 'core' . DS . 'Router.php';

// Init Database
$DB = new Database(BDD_HOST, BDD_USER, BDD_PASS, BDD_DB);
$router = new Router();

$router->addRoute("devblog/page/**", "devblog");
$router->addRoute("devblog/*", "devblog/article");

$router->load();
