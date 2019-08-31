<?php

namespace UtariaV1;

class ToolsController extends Controller
{

    public function admin_feedbacks()
    {
        if (getGet("data") != null) {
            $data = (Array)$this->DB->find(array(
                "table" => "feedbacks",
                "fields" => array("playername", "service", "description", "date", "priority"),
                "order" => "date desc"
            ));

            printJSON(array("aaData" => $data));
        }
    }

    public function admin_priceitemchanger()
    {
        if (getGet("itemdata") != null) {
            $item = getGet("itemdata");
            $log = $this->DB->req("SELECT playername, sum(balance_change) as S, sum(amount) as A, money FROM survie_shops_log JOIN survie_items ON survie_shops_log.item_id = survie_items.id JOIN players ON players.id = survie_shops_log.player_id JOIN survie_money ON survie_money.player_id = players.id WHERE survie_items.id = " . $item . " GROUP BY survie_shops_log.player_id, type ORDER BY S DESC");
            echo(json_encode($log));
            die();
            exit();
        }

        $items = $this->DB->find(array(
            "table" => "survie_items",
            "fields" => array("id", "name", "sold_price", "buying_price", "material_id", "material_data"),
            "order" => "name asc"
        ));

        $this->set((object)array(
            "items" => $items
        ));
    }

    public function admin_modifconfig()
    {
        if (isPost()) {
            foreach (getPost() as $key => $value) {
                if ($key == "antibot_protection_enabled")
                    $value = ($value == "on") ? "true" : "false";
                else if ($key == "disable_autorestart")
                    $value = ($value == "on") ? "false" : "true";
                else if ($key == "autorestart_hour")
                    $value = str_replace(":", "h", $value);


                $this->DB->save(array(
                    "table" => "config",
                    "fields" => array("value" => $value),
                    "where" => "key",
                    "wherevalue" => $key
                ));
            }

            setNotif("Configuration sauvegardée avec succès !");
        }


        $this->set($this->DB->find(array("table" => "config")));
    }

}
