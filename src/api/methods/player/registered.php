<?php
function run($params)
{
    if (!isset($params["name"])) return array("registered" => false);

    $player = getDB()->findFirst(array(
        "table" => "players",
        "conditions" => array("playername" => $params["name"])
    ));

    return array("registered" => !empty($player));
}
