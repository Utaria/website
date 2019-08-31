<?php
function run($params)
{
    require LIB . DS . 'minecraft' . DS . 'MinecraftPingException.php';
    require LIB . DS . 'minecraft' . DS . 'MinecraftPing.php';

    $ping = null;
    $p = -1;

    try {
        $ping = new MinecraftPing("mc.utaria.fr");

        $p = $ping->Query()["players"]["online"];
    } catch (MinecraftPingException $e) {
    } finally {
        if ($ping != null) $ping->Close();
    }

    return array("players" => $p);
}
