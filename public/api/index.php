<?php

use UtariaV1\Config;

error_reporting(E_ALL);
ini_set("display_errors", 1);
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
ini_set('memory_limit', '-1');

define('WEBROOT', dirname(dirname(__FILE__)));
define('ROOT', dirname(WEBROOT));
define('DS', DIRECTORY_SEPARATOR);
define('SRC', ROOT . DS . 'src');
define('LIB', SRC . DS . 'api' . DS . 'lib');

require SRC . DS . 'core' . DS . 'Config.php';
require SRC . DS . 'api' . DS . 'util.php';
require SRC . DS . 'core' . DS . 'Database.php';

// --- Mise en place du header JSON
header('Content-Type: application/json');

if (isset($_GET["uri"])) {
    $uri = $_GET["uri"];
} else {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
}

$uri = str_replace("/api", "", $uri);
$base = "methods";
$method_file = SRC . DS . 'api' . DS . $base . $uri . ".php";

// On regarde si la méthode existe bien.
if (!file_exists($method_file)) {
    error(1, "Methode inconnue.");
}

require_once $method_file;

// On regarde si la fonction run a bien été définie dans le fichier.
if (!function_exists("run")) error(2, "Appel de la methode impossible.");

if (isset($protected) && $protected) {
    if (!isset($_GET["token"]))
        error(10, "Token obligatoire pour appeler cette methode.");

    if (!in_array($_GET["token"], Config::$apiAuthorizedTokens))
        error(11, "Token incorrect.");
}

// On lance la méthode de l'API
unset($_GET["uri"]);
$results = run($_GET);

// Si elle ne retourne rien (mais pas true), on affiche "aucun résultat".
if (empty($results) && $results !== true) error(3, "Aucun resultat.");
if (is_string($results)) $results = array("resultat" => $results);

// On ajoute l'heure actuelle au retour
$results["request_time"] = time();

echo json_encode($results);
