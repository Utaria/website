<?php
session_start();
$VERSION = "0.0.1";

define('DS', DIRECTORY_SEPARATOR);
define('SRC', dirname(dirname(dirname(dirname(__FILE__)))) . DS . 'src');

require SRC . DS . 'core' . DS . 'Config.php';
require SRC . DS . 'core' . DS . 'Database.php';
require SRC . DS . 'core' . DS . 'functions.php';
require SRC . DS . 'api' . DS . 'util.php';


$db = getDB();

$items = $db->find(array("table" => "survie_items", "fields" => "id,name,material_id,material_data", "order" => "material_id asc, material_data asc"));

$itemId = getGet("i");
$playername = getGet("p");
$date = (getGet("d") != null && getGet("d") != " ") ? getGet("d") : null;
$mode = getGet("m");

if (getGet("search") != null) {
    $data = (object)array();
    $conditions = array();

    /*  On mets les valeurs dans la requête pour récupérer les bonnes valeurs.  */
    if ($itemId != null && $itemId != "all")
        $conditions["item_id"] = $itemId;
    if ($playername != null)
        $conditions["playername"] = $playername;
    if ($date != null)
        $conditions["date(date)"] = $date;
    if ($mode == "v")
        $conditions["type"] = "SELLING";
    if ($mode == "a")
        $conditions["type"] = "BUYING";

    $reqOpts = array(
        "table" => "survie_shops_log join survie_items on survie_items.id = survie_shops_log.item_id join players on players.id = survie_shops_log.player_id",
        "fields" => "amount, balance_change, date, item_id, material_id, material_data, name, playername, type",
        "conditions" => $conditions,
        "order" => "date desc"
    );

    if ($date == null && $playername == null && $itemId == "all") $reqOpts["limit"] = "0,50";

    $data = $db->find($reqOpts);

    die(json_encode($data));
}
?>
<!DOCTYPE html>
<html lang="fr">
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

  <title>Panel Utaria | L'économie du survie</title>

  <meta name="viewport" content="width=device-width, initial-scale = 1, user-scalable = no">

  <meta name="twitter:card" content="summary">
  <meta name="twitter:site" content="@Utaria_FR">
  <meta name="twitter:title" content="Utaria, les serveurs de demain !">
  <meta name="twitter:description" content="Utaria, un serveur Minecraft innovant.">
  <meta property="og:title" content="Utaria">
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://utaria.fr/">

  <link rel="icon" type="image/png" href="/img/favicon.png"/>

  <link href="https://fonts.googleapis.com/css?family=Lato|Open+Sans:300,400,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <link rel="stylesheet" type="text/css" href="./style.css">
  <link rel="stylesheet" type="text/css" href="./table.css">
</head>
<body>

<section id="main">
  <div class="main-container paysafe-container" data-version="<?= $VERSION ?>">
    <h1>L'économie du survie : les transactions</h1>

    <form id="tri" method="GET" action="" onsubmit="return false;">
      <div class="input">
        <label for="itemfilter">Item</label>
        <select name="i" id="itemfilter" style="max-width:230px" onchange="reloadData();">
          <option value="all"<?= ($itemId == null) ? " selected" : "" ?>>Tous</option>
            <?php foreach ($items as $v): ?>
              <option value="<?= $v->id ?>"<?= ($itemId == $v->id) ? " selected" : "" ?>>
                  <?= $v->name; ?> (<?= $v->material_id; ?><?= ($v->material_data > 0) ? ":" . $v->material_data : "" ?>
                )
              </option>
            <?php endforeach ?>
        </select>
      </div>

      <div class="input">
        <label for="playername">Joueur</label>
        <input type="text" name="p" id="playername" <?= ($playername != null) ? 'value="' . $playername . '"' : "" ?>
               style="width:140px" placeholder="Nom du joueur" onchange="reloadData();">
      </div>

      <div class="input">
        <label for="date">Date</label>
        <input type="date" name="d" id="date" max="<?= date("Y-m-d") ?>" value="<?= $date ?>"
               placeholder="Date de recherche" onchange="reloadData();">
      </div>

      <div class="input">
        <label for="mode">Mode</label>
        <select name="m" id="mode" onchange="reloadData();">
          <option value="b">Tout</option>
          <option value="a">Achat</option>
          <option value="v">Vente</option>
        </select>
      </div>

      <div class="clear"></div>
    </form>

    <div class="search-bilan">
      <br/>
      Argent total : <span id="earned_money">--</span> pièces
    </div>

    <table class="responstable" id="data_table">
      <tr>
        <th>Pseudo</th>
        <th>Heure</th>
        <th>Item</th>
        <th>Nombre</th>
        <th>Argent</th>
      </tr>

      <tr class="loading" id="loader_tr">
        <td colspan="5">
          <div class="cssload-thecube">
            <div class="cssload-cube cssload-c1"></div>
            <div class="cssload-cube cssload-c2"></div>
            <div class="cssload-cube cssload-c4"></div>
            <div class="cssload-cube cssload-c3"></div>
          </div>
          <br/>
        </td>
      </tr>

      <tbody id="search_results"></tbody>
    </table>
  </div>
</section>

<script type="text/javascript">
    function reloadData () {
        var form = document.getElementById("tri");
        var table = document.getElementById("data_table").childNodes[1];
        var results = document.getElementById("search_results");
        var loader = document.getElementById("loader_tr");

        /*  On formatte les paramètres du formulaire  */
        var params = {
            "search": true,
            "i": form.querySelector("#itemfilter").value,
            "p": form.querySelector("#playername").value,
            "d": form.querySelector("#date").value,
            "m": form.querySelector("#mode").value
        };

        /*  On lance la requête, on démarre le loader */
        var req = new XMLHttpRequest();

        results.innerHTML = "";
        loader.style.display = "block";

        req.open('GET', buildUrl('/panel/economie/', params), true);
        req.onreadystatechange = function (aEvt) {
            if (req.readyState == 4 && req.status == 200) {
                var data = JSON.parse(req.responseText);
                var totalMoney = 0.0;

                /*  Les données viennent d'être récupérés, on cache le loader,
                              et on affiche les données dan le tableau.                  */
                loader.style.display = "none";

                for (var row of data) {
                    var date = new Date(row.date);
                    var day = new Date().toLocaleDateString();

                    var el = document.createElement("tr");
                    el.className = "row-data";

                    el.innerHTML = '<td class="item"><img src="https://minotar.net/avatar/' + row.playername + '/32" /> ' + row.playername + '</td>';

                    // Date
                    var stringTime = "<td>";
                    if (date.toLocaleDateString() != day)
                        stringTime += pad(date.getDate(), 2) + "/" + pad(date.getMonth() + 1, 2) + "/" + date.getFullYear() + " à ";

                    stringTime += pad(date.getHours(), 2) + ":" + pad(date.getMinutes(), 2) + ":" + pad(date.getSeconds(), 2) + "</td>";

                    el.innerHTML += stringTime;

                    el.innerHTML += '<td class="item"><img src="./items/' + row.material_id + '-' + row.material_data + '.png" /> ' + row.name + '</td>';
                    el.innerHTML += '<td>' + row.amount + '</td>';
                    el.innerHTML += '<td>' + parseFloat(row.balance_change).toFixed(3).replace('.', ',') + '</td>';

                    totalMoney += Math.abs(parseFloat(row.balance_change));

                    results.appendChild(el);
                }

                document.querySelector("#earned_money").innerHTML = totalMoney.toFixed(3).replace('.', ',');
            }
        };

        req.send(null);
    }

    function pad (n, width, z) {
        z = z || '0';
        n = n + '';
        return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
    }

    function buildUrl (url, parameters) {
        var qs = "";
        for (var key in parameters) {
            var value = parameters[key];
            qs += encodeURIComponent(key) + "=" + encodeURIComponent(value) + "&";
        }

        if (qs.length > 0) {
            qs = qs.substring(0, qs.length - 1);
            url = url + "?" + qs;
        }
        return url;
    }

    setTimeout(reloadData, 1000 * 30);

    window.onload = reloadData;
</script>

</body>
</html>
