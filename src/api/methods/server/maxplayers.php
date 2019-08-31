<?php

function run($params)
{
    $maxplayers = getDB()->findFirst(array(
        "table" => "config",
        "conditions" => array("key" => "maxplayers")
    ))->value;

    return array("maxplayers" => intval($maxplayers));
}
