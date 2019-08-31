<?php

function run($params)
{
    if (isset($params["date"])) {
        $updateDate = getDB()->findFirst(array(
            "table" => "admin_documents",
            "conditions" => array("id" => 2)
        ))->modification_time;

        return array("update_date" => strtotime($updateDate));
    }

    header("Content-Type: application/pdf");
    readfile("/home/ftp/utariafr/www/admindoc/2.pdf");
}
