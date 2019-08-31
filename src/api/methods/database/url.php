<?php
$protected = true;

function run($params)
{
    if (isset($params["environment"]))
        switch ($params["environment"]) {
            case "development":
                return "utaria.dev";
            case "production" :
                return "213.32.65.249";
        }
}
