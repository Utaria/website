<?php
$VERSION = "0.0.1";
require_once '/var/www/utaria.fr/api/Database.php';

$db = new Database();
$db->connect("localhost", "api", "+87*A9Rn^Y:*_8_a:x", "utaria");

$feedbacks = $db->find(array(
    "table" => "feedbacks",
    "order" => "date desc"
));
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

  <title>Panel Utaria | Les retours</title>

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
  <link rel="stylesheet" type="text/css" href="./style.css">
  <link rel="stylesheet" type="text/css" href="./table.css">
</head>
<body>

<section id="main">
  <div class="main-container feedbacks-container" data-version="<?= $VERSION ?>">
    <h1>La liste des retours (Temporaire)</h1>

    <table class="responstable">
      <tr>
        <th>Auteur</th>
        <th>Date</th>
        <th>Service</th>
        <th>Description</th>
        <th>Priorité</th>
      </tr>

        <?php foreach ($feedbacks as $v): ?>
          <tr>
            <td><?= $v->playername ?></td>
            <td width="150"
                style="text-align:center"><?= date("d/m/Y", strtotime($v->date)) . "<br>à<br>" . date("H:i:s", strtotime($v->date)) ?></td>
            <td width="200"><?= $v->service ?></td>
            <td width="500"><?= $v->description ?></td>
            <td><?= $v->priority ?></td>
          </tr>
        <?php endforeach ?>

    </table>
  </div>
</section>

</body>
</html>
