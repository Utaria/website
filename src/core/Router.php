<?php

namespace UtariaV1;

class Router
{

    public $routes = array();

    public $redirects = array();

    public $params = array();

    public $page = "";

    public $lang = null;

    public function __construct()
    {
        $this->lang = Config::$lang;
    }

    public function load()
    {
        $this->format();
        $this->hook();
        $this->parse();
        $this->loadPage();
    }


    public function format()
    {
        $suffix = "";

        if (isset($_GET['p'])) {
            $this->page = !empty($_GET['p']) ? addslashes(htmlentities($_GET['p'])) : null;
        } else {
            $this->page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        }

        // On enlève les slash du début/fin de la chaîne
        $this->page = trim($this->page, '/');

        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
        define('BASE_URL', $protocol . $_SERVER['HTTP_HOST'] . '/');

        if ($this->page == 'home' || $this->page == '') {
            $this->page = 'index';
        }
        if ($this->page == "\'\'\'") {
            redirect(BASE_URL);
        }
        if ($this->page == "connexion") {
            $this->page = "login";
        }
    }

    public function parse()
    {

        // Redirections
        foreach ($this->redirects as $regex => $v) {
            $regex = "/" . preg_replace("/\//", "\/", $regex) . "/";

            if (preg_match($regex, $this->page))
                redirect($v);
        }

        // Routes
        foreach ($this->routes as $regex => $v) {
            if (strpos($this->page, "admin_") !== false) break;

            $regex = preg_replace("/\*\*/", "([0-9]+)", $regex);
            $reg = "/" . preg_replace("/\//", "\/", preg_replace("/\*/", "(.*)", $regex)) . "/";
            $matches = array();

            $subpath = (strpos($v, "[.]") !== false);
            if ($subpath) $v = str_replace("[.]", "", $v);

            if (preg_match($reg, $this->page, $matches)) {

                if (empty($matches)) continue;
                array_shift($matches);

                if ($subpath) {
                    $f = $this->page;
                    foreach ($matches as $v) $f = str_replace($v, "", $f);

                    $v = str_replace("//", "/", $f);
                    if (substr($v, -1) == "/") $v = substr($v, 0, -1);
                }
                $this->page = $v;

                if (count($matches) == 1) {
                    $this->params = addslashes(htmlentities($matches[0]));
                    continue;
                }

                foreach ($matches as $v)
                    $this->params[] = addslashes(htmlentities($v));
            }
        }

        if (is_array($this->params)) {
            foreach ($this->params as $k => $v)
                if (strpos($v, "/") !== false)
                    $this->params[$k] = explode("/", $v);
        } else {
            if (strpos($this->params, "/") !== false) {
                $this->params = explode("/", $this->params);

                if (count($this->params) == 2 && empty($this->params[1]))
                    $this->params = $this->params[0];
            }
        }
    }

    public function hook()
    {
        $split = preg_split("/\//", $this->page);

        if (count($split) > 0 && $split[0] === ADMIN_PREFIX) {
            if (count($split) > 2)
                $this->page = $split[1] . '/admin_' . $split[2];
            else if (count($split) > 1 && $split[1] != "")
                $this->page = $split[1] . '/admin_index';
            else
                $this->page = "index/admin_index";

            if (count($split) > 3) {
                // On supprime les 3 premiers élements du tableau pour récupérer
                // seulement les paramètres.
                array_shift($split);
                array_shift($split);
                array_shift($split);

                // On a donc des paramètres dans le tableau $split.
                $this->params = $split;
            }

            // Redirection vers la page de login si pas connecté
            if ($this->page != "user/admin_login" && !getUser())
                redirect(BASE_URL . ADMIN_PREFIX . "/user/login");

            // Protection des pages en globalité
            if (!preg_match("/user\//", $this->page)) {
                $user = getUser();

                if ($user->adminRole == "redactor") {
                    $ok = false;

                    foreach (Config::$allowedAdminPages[$user->adminRole] as $regex) {
                        if (preg_match("/" . $regex . "/", $this->page)) {
                            $ok = true;
                            break;
                        }
                    }

                    if (!$ok) redirect(BASE_URL . ADMIN_PREFIX . "/devblog/articles");
                }

                if ($user->adminRole == "member") {
                    $ok = false;

                    foreach (Config::$allowedAdminPages[$user->adminRole] as $regex) {
                        if (preg_match("/" . $regex . "/", $this->page)) {
                            $ok = true;
                            break;
                        }
                    }

                    if (!$ok) redirect(BASE_URL . ADMIN_PREFIX . "/user");
                }
            }

            Config::$templateName = "admin";
        }

        if ($this->page == "/connexion") $this->page = "login";
    }

    public function loadPage()
    {
        if ($this->page == null) return false;
        global $DB;

        // Call the controller
        $viewFile = SRC . DS . 'views' . DS . $this->page . '.php';
        $fileExist = file_exists($viewFile) ? true : false;
        $ctrlName = "Index";
        $action = "index";

        if (!$fileExist) {
            @header("HTTP/1.0 404 Not Found");
            $this->page = "errors/error404";
        }

        $split = preg_split("/\//", $this->page);
        if (count($split) > 0) $ctrlName = ucfirst($split[0]);
        if (count($split) > 1) $action = ucfirst($split[1]);

        $action = str_replace("-", "_", $action);

        $ctrlName = $ctrlName . 'Controller';
        require(SRC . DS . 'controllers' . DS . $ctrlName . '.php');

        $className = __NAMESPACE__ . '\\' . $ctrlName;
        $ctrl = new $className($DB);
        $action = strtolower($action);
        $ctrl->$action($this->params);

        $d = $ctrl->getData();

        $content_for_layout = false;

        // Custom vars
        $header = ($this->page == 'index') ? true : false;

        $page = $this->page;
        $lang = $this->lang;
        global $Html;

        $doMaintenance = false;
        $shouldMaintenance = (Config::$maintenance === true || (is_array(Config::$maintenance) && in_array($page, Config::$maintenance)));

        if ($shouldMaintenance && (!getUser() || !isAdmin(getUser())) && $ctrlName != "LoginController")
            $doMaintenance = true;

        if ($shouldMaintenance) Config::$pageInDev = true;

        if ($doMaintenance) {
            $protocol = "HTTP/1.0";
            if ("HTTP/1.1" == $_SERVER["SERVER_PROTOCOL"]) $protocol = "HTTP/1.1";

            header("$protocol 503 Service Unavailable", true, 503);
            header("Retry-After: 3600");
            $this->page = "errors/error503";
        }

        $view = $ctrl->getView($this->page);

        ob_start();
        require SRC . DS . 'views' . DS . $view . '.php';
        $content_for_layout = ob_get_clean();
        require SRC . DS . 'views' . DS . 'templates' . DS . Config::$templateName . '.php';
    }

    public function addRoute($regex, $to)
    {
        $this->routes[$regex] = $to;
    }

    public function addRedirection($regex, $to)
    {
        $this->redirects[$regex] = $to;
    }

}
