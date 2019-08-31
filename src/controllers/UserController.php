<?php

namespace UtariaV1;

class UserController extends Controller
{

    public function admin_index()
    {

    }

    public function admin_login()
    {
        if (isPost()) {
            $playername = getPost("playername");
            $password = getPost("password");

            $user = $this->DB->findFirst(array(
                "table" => "players",
                "conditions" => array(
                    "playername" => $playername,
                    "password" => sha1($password)
                )
            ));

            if (!$user) {
                $this->set("Identifiants incorrects !");
                return;
            }

            if (!in_array($user->playername, array_keys(Config::$allowedAdminUsers))) {
                $this->set("Le panel est réservé aux membres du staff.");
                return;
            }

            unset($user->password);
            $user->adminRole = Config::$allowedAdminUsers[$user->playername];
            $_SESSION["user"] = $user;

            setNotif("Connecté au panel avec succès ! Amusez-vous bien ;-)");
            //redirect(BASE_URL . ADMIN_PREFIX);
        }
    }

    public function admin_logout()
    {
        if (!getUser()) redirect(BASE_URL . ADMIN_PREFIX);

        unset($_SESSION["user"]);
        setNotif("Déconnecté avec succès ! Fermez l'onglet pour cloturer la session.");
        redirect(BASE_URL . ADMIN_PREFIX);
    }

}
