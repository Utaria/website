<?php
// 1. Copy this sample config file to the src/core folder.
// 2. Rename the file to Config.php

namespace UtariaV1;

define('BDD_HOST', 'localhost');
define('BDD_USER', 'root');
define('BDD_PASS', 'root');
define('BDD_DB', 'utaria');

define('ADMIN_PREFIX', 'admin_v1');
define('VERSION', '0.2.0');

class Config
{

    public static $templateName = "v1";
    public static $lang = "fr";
    public static $maintenance = false;

    public static $pageInDev = false;
    public static $noel = false;

    public static $pageTitle = "Utaria | Serveur Minecraft innovant";
    public static $pageDescription = "Utaria, les serveurs de demain ! Marre du survie classique de Minecraft ? Venez tester notre survie UNIQUE sur mc.utaria.fr !";

    public static $allowedAdminUsers = array(
        "Utarwyn" => "admin",
        "Yukams" => "admin"
    );
    public static $allowedAdminPages = array(
        "redactor" => array(
            "devblog*",
            "documents*"
        ),
        "member" => array(
            "documents*"
        )
    );

    public static $apiAuthorizedTokens = array(
        "apitoken"
    );

}
