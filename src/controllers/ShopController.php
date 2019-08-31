<?php

namespace UtariaV1;

class ShopController extends Controller
{

    public function admin_history()
    {
        if (getGet("data") != null) {
            $data = array();
            $orders = $this->DB->req(
                "SELECT * FROM shop_log " .
                "JOIN players ON players.id = shop_log.player_id " .
                "JOIN shop_coins_products ON shop_coins_products.id = shop_log.shop_coins_product_id"
            );

            function formatPaymentMean($payment_mean)
            {
                switch ($payment_mean) {
                    case "cb"         :
                        return "CB";
                    case "paypal"     :
                        return "PayPal";
                    case "paysafecard":
                        return "Carte Paysafe";
                    case "youpass"    :
                        return "YouPass";

                    default:
                        return $payment_mean;
                }
            }

            foreach ($orders as $v)
                $data[] = array(
                    "playername" => $v->playername,
                    "payment_mean" => formatPaymentMean($v->payment_mean),
                    "ordertime" => $v->ordertime,
                    "coins_buyed" => $v->coins,
                    "order_value" => $v->price . "€"
                );

            printJSON(array("aaData" => $data));
        }
    }

    public function admin_paysafecards()
    {
        if (getGet("data") != null) {
            $data = array();
            $orders = $this->DB->req(
                "SELECT * FROM shop_paysafe_codes " .
                "JOIN players ON players.id = shop_paysafe_codes.player_id " .
                "JOIN shop_coins_products ON shop_coins_products.id = shop_paysafe_codes.coins_product_id"
            );

            foreach ($orders as $v)
                $data[] = array(
                    "playername" => $v->playername,
                    "email" => $v->email,
                    "date" => $v->date,
                    "product" => $v->coins . " coins (" . $v->price . "€)",
                    "code" => $v->code,
                    "validated" => ($v->validated) ? "Oui" : "Non",
                    "actions" => (!$v->validated) ? "<button>Valider</button>" : ""
                );

            printJSON(array("aaData" => $data));
        }
    }

}
