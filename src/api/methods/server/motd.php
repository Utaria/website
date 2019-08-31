<?php
function run($params)
{
    require LIB . DS . 'minecraft' . DS . 'MinecraftPingException.php';
    require LIB . DS . 'minecraft' . DS . 'MinecraftPing.php';

    $ping = null;
    $p = -1;

    try {
        $ping = new MinecraftPing("mc.utaria.fr");

        var_dump($ping->Query());
        die();

    } catch (MinecraftPingException $e) {
    } finally {
        if ($ping != null) $ping->Close();
    }

    return array("players" => $p);
}
