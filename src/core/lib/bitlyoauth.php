<?php

class BitlyOAuth
{

    private $CODE = "3089e2da39f07310de1fe608645b546d20224286";

    private $idKey;
    private $secretKey;


    public function __construct($idKey, $secretKey)
    {
        $this->idKey = $idKey;
        $this->secretKey = $secretKey;
    }

    public function shorten($link)
    {
        $accessToken = $this->getAccessToken();
        var_dump($accessToken);

        return $link;
    }


    private function getAccessToken()
    {
        $redirect_uri = "https://utaria.fr/core/lib/bitlyoauth.php";
        $uri = "https://api-ssl.bitly.com/oauth/access_token";

        //POST to the bitly authentication endpoint
        $params = array();
        $params['client_id'] = $this->idKey;
        $params['client_secret'] = $this->secretKey;
        $params['code'] = $this->CODE;
        $params['redirect_uri'] = $redirect_uri;

        $output = "";
        $params_string = "";
        foreach ($params as $key => $value) {
            $params_string .= $key . '=' . $value . '&';
        }

        rtrim($params_string, '&');

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $uri);
            curl_setopt($ch, CURLOPT_POST, count($params));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
        } catch (Exception $e) {

        }

        return json_decode($output)->access_token;
    }


    public static function rapidShorten($link, $accessToken)
    {
        $url = 'https://api-ssl.bitly.com/v3/shorten?access_token=' . $accessToken . '&longUrl=' . urlencode($link) . '&domain=bit.ly';

        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 4);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            $output = json_decode(curl_exec($ch));
        } catch (Exception $e) {
        }

        if (isset($output)) return $output->data->url;
        else               return null;
    }

}

?>
