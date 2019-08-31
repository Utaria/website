<?php
$VERSION = "0.0.1";
require_once '/var/www/utaria.fr/api/Database.php';

$db = new Database();
$db->connect("localhost", "api", "+87*A9Rn^Y:*_8_a:x", "utaria");

$codes = $db->req("SELECT * from shop_paysafe_codes join players on players.id = shop_paysafe_codes.player_id join shop_coins_products on shop_coins_products.id = shop_paysafe_codes.coins_product_id order by shop_paysafe_codes.id desc");
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="description"
        content="Utaria, les serveurs de demain ! Marre du survie classique de Minecraft ? Venez tester notre survie UNIQUE sur mc.utaria.fr !">
  <meta name="keywords" content="minecraft,serveur minecraft,serveur,survie unique,unique,original,nouveau,survival">
  <meta name="author" content="Utaria">
  <meta name="dcterms.rightsHolder" content="utaria">
  <meta name="Revisit-After" content="2 days">
  <meta name="Rating" content="general">
  <meta name="language" content="fr-FR"/>
  <meta name="robots" content="all"/>
  <meta charset="UTF-8">

  <title>Panel Utaria | Les code Paysafecard entrés</title>

  <meta name="viewport" content="width=device-width, initial-scale = 1, user-scalable = no">

  <meta name="twitter:card" content="summary">
  <meta name="twitter:site" content="@Utaria_FR">
  <meta name="twitter:title" content="Utaria, les serveurs de demain !">
  <meta name="twitter:description" content="Utaria, un serveur Minecraft innovant.">
  <meta property="og:title" content="Utaria">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://utaria.fr/">

  <link rel="icon" type="image/png" href="//utaria.fr/img/favicon.png"/>

  <link href="https://fonts.googleapis.com/css?family=Lato|Open+Sans:300,400,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="//utaria.fr/css/style.min.css">
  <link rel="stylesheet" type="text/css" href="../feedbacks/style.css">
  <link rel="stylesheet" type="text/css" href="../feedbacks/table.css">
</head>
<body>

<section id="main">
  <div class="main-container paysafe-container" data-version="<?= $VERSION ?>">
    <h1>La liste des codes (Temporaire)</h1>

    <table class="responstable">
      <tr>
        <th>Pseudo</th>
        <th>Date</th>
        <th>Produit</th>
        <th>Code</th>
      </tr>

        <?php foreach ($codes as $v): ?>
          <tr>
            <td><?= $v->playername ?></td>
            <td width="150"
                style="text-align:center"><?= date("d/m/Y", strtotime($v->date)) . "<br>à<br>" . date("H:i:s", strtotime($v->date)) ?></td>
            <td width="200"><?= $v->coins; ?> coins</td>
            <td><?= $v->code; ?></td>
          </tr>
        <?php endforeach ?>

    </table>
  </div>
</section>

</body>
</html>
