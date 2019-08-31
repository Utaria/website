<?php
$protected = true;

function run($params)
{
    if (!isset($params["name"]) || !isset($params["password"])) return array("auth" => false, "player_id" => null);

    $player = getDB()->findFirst(array(
        "table" => "players",
        "conditions" => array(
            "playername" => $params["name"]
        )
    ));

    $errMsg = null;
    $authOk = false;
    $exists = !empty($player);

    if ($exists) {
        if ($params["password"] == $player->password)
            $authOk = true;
        else
            $errMsg = "wrong_password";
    } else {
        $errMsg = "unknown_account";
    }

    return array(
        "auth" => $authOk,
        "error_msg" => $errMsg,
        "player_id" => ($authOk) ? $player->id : null
    );

}
