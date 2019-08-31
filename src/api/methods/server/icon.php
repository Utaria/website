<?php
function run($params)
{
    require LIB . DS . 'minecraft' . DS . 'MinecraftPingException.php';
    require LIB . DS . 'minecraft' . DS . 'MinecraftPing.php';

    $ping = null;
    $image = null;

    try {
        $ping = new MinecraftPing("mc.utaria.fr");

        if (isset($params["image"])) {
            $codeBase64 = $ping->Query()["favicon"];
            $codeBase64 = str_replace('data:image/png;base64,', '', $codeBase64);
            $codeBinary = base64_decode($codeBase64);

            $image = imagecreatefromstring($codeBinary);
            header('Content-Type: image/png');
            imagejpeg($image);
            imagedestroy($image);
        }

        $image = $ping->Query()["favicon"];
    } catch (MinecraftPingException $e) {
    } finally {
        if ($ping != null) $ping->Close();

        if (isset($params["image"])) die();
    }

    return $image;
}
