<?php

function run($params)
{
    if (!isset($params["id"])) return array("playername" => null);

    $player = getDB()->findFirst(array(
        "table" => "players",
        "conditions" => array("id" => $params["id"])
    ));

    if (empty($player)) return array("playername" => null);

    return array("playername" => $player->playername);

}
