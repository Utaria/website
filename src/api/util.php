<?php

use UtariaV1\Database;

$DB = null;

function error($code = 0, $message)
{
    echo json_encode(array(
        "error" => array(
            "code" => $code,
            "message" => $message
        )
    ));

    exit();
}

function getDB()
{
    global $DB;
    if (is_null($DB)) {
        $DB = new Database(BDD_HOST, BDD_USER, BDD_PASS, BDD_DB);
    }

    return $DB;
}
