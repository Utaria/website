<?php
function run($params)
{
    $maintenance = getDB()->findFirst(array(
        "table" => "config",
        "conditions" => array("key" => "maintenance")
    ));

    $players = -1;
    $maxplayers = -1;

    if (!$maintenance->value) {
        require LIB . DS . 'minecraft' . DS . 'MinecraftPingException.php';
        require LIB . DS . 'minecraft' . DS . 'MinecraftPing.php';

        $ping = null;
        $p = -1;

        try {
            $ping = new MinecraftPing("mc.utaria.fr");

            $players = $ping->Query()["players"]["online"];
        } catch (MinecraftPingException $e) {
        } finally {
            if ($ping != null) $ping->Close();
        }

        $maxplayers = getDB()->findFirst(array(
            "table" => "config",
            "conditions" => array("key" => "maxplayers")
        ))->value;
    }

    return array(
        "players" => $players,
        "maxplayers" => $maxplayers,
        "maintenance" => $maintenance->value
    );
}
