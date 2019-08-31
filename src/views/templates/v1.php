<!DOCTYPE html>
<html lang="fr">
<head>
  <!-- Données récupérées par les moteurs de recherche -->
  <meta name="description" content="<?= UtariaV1\Config::$pageDescription ?>">
  <meta name="keywords" content="minecraft,serveur minecraft,serveur,survie unique,unique,original,nouveau,survival">
  <meta name="author" content="Utaria">
  <meta name="dcterms.rightsHolder" content="utaria">
  <meta name="Revisit-After" content="2 days">
  <meta name="Rating" content="general">
  <meta name="language" content="fr-FR"/>
  <meta name="robots" content="all"/>
  <meta charset="UTF-8">

  <title><?= UtariaV1\Config::$pageTitle; ?></title>

  <meta name="viewport" content="width=device-width, initial-scale = 1, user-scalable = no">

  <!-- Données récupérées par les réseaux sociaux -->
  <meta name="twitter:card" content="summary">
  <meta name="twitter:site" content="@Utaria_FR">
  <meta name="twitter:image" content="https://utaria.fr/img/logo-square.jpg">
    <?php if ($page != "devblog/article"): ?>
      <meta name="twitter:title" content="Utaria, les serveurs de demain !">
      <meta name="twitter:description" content="Utaria, un serveur Minecraft innovant.">
    <?php else: ?>
      <meta name="twitter:title" content="<?= prepareForMeta($d->article->title, 70) ?>">
      <meta name="twitter:description" content="<?= prepareForMeta($d->article->content, 197) ?>">
    <?php endif; ?>
  <meta property="og:locale" content="fr_FR">
  <meta property="og:url" content="https://utaria.fr<?= $_SERVER["REQUEST_URI"] ?>">
  <meta property="og:image" content="https://utaria.fr/img/logo-square.jpg">
  <meta property="og:site_name" content="Utaria">
    <?php if ($page != "devblog/article"): ?>
      <meta property="og:type" content="website">
      <meta property="og:title" content="Utaria, les serveurs de demain !">
      <meta property="og:description" content="Utaria, un serveur Minecraft innovant.">
    <?php else: ?>
      <meta property="og:type" content="article">
      <meta property="og:title" content="<?= prepareForMeta($d->article->title, 70) ?>">
      <meta property="og:description" content="<?= prepareForMeta($d->article->content, 297) ?>">
      <meta property="article:published_time" content="<?= $d->article->date ?>">
    <?php endif; ?>

  <!-- Bonjour, je suis une icône. -->
  <link rel="icon" type="image/png" href="/img/favicon.png"/>

  <!-- Styles CSS divers et variés -->
  <link href="https://fonts.googleapis.com/css?family=Lato|Open+Sans:400,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/css/style.css">
    <?php if ($page != "index"): ?>
      <link rel="stylesheet" type="text/css" href="/css/global.css?v=<?= time() ?>">
    <?php endif; ?>
    <?php if ($page == "devblog/article"): ?>
      <link rel="stylesheet" type="text/css" href="/css/lightgallery.min.css">
    <?php endif; ?>

  <link rel="stylesheet" media="screen and (max-width: 420px)" type="text/css" href="/css/mobile.css">
  <style type="text/css" media="screen">
    @-webkit-keyframes disco {
    <?php
        for($i=0;$i<=100;$i++){
            echo create_animation_frame($i);
            $i++;
        }
        ?>
    }
  </style>
</head>
<body>

<header>
  <div class="main-bar row-container">
    <div class="left">
      <a href="<?= BASE_URL ?>" title="Utaria, les serveurs de demain !">
        <div id="logo"></div>
      </a>
    </div>
    <div class="right">
      <nav class="primary-menu">
        <a href="//boutique.utaria.fr/" target="_blank" title="La boutique d'Utaria">
          <div class="item special-2 shake-item">Boutique</div>
        </a>
        <a href="//feedback.utaria.fr/" target="_blank" title="Poster un avis dès maintenant">
          <div class="item">Poster un avis</div>
        </a>
        <a href="/devblog" title="Blog de développement">
          <div class="item special disco-item">
            Blog
          </div>
        </a>
        <a href="/voter" target="_blank" rel="nofollow" title="Voter pour nous">
          <div class="item">Voter</div>
        </a>
      </nav>
    </div>
  </div>

  <div class="clear"></div>
</header>


<section id="main">
    <?= $content_for_layout; ?>
</section>


<footer>
  <div class="left">
    <p>
      Pour suivre les nouveautés :&nbsp;&nbsp; <a href="https://twitter.com/Utaria_FR" class="twitter-follow-button"
                                                  data-lang="fr" data-show-count="false">Suivre @Utaria_FR</a>
      <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
      <br/>
      Voter pour <a href="http://www.minecraft-serveurs.com/75-utaria" style="color:white">Utaria</a> sur le classement
      <a href="http://www.minecraft-serveurs.com" style="color:white">Minecraft Serveurs</a>
    </p>
  </div>
  <div class="center">
    <span class="copyright">Utaria n'est pas affilié à Mojang.<br>Site internet par <b>Utarwyn</b>.</span>
  </div>
  <div class="right">
    <a href="//boutique.utaria.fr/conditions/generales" target="_BLANK" title="Conditions générales">Conditions
      générales</a>&nbsp;-&nbsp;<a href="//boutique.utaria.fr/conditions/vente" target="_BLANK"
                                   title="Conditions de vente">Conditions de vente</a>&nbsp;-&nbsp;<a
        href="//boutique.utaria.fr/conditions/reglement" target="_BLANK" title="Règlement">Règlement</a>
  </div>
</footer>


<?php if (UtariaV1\Config::$noel): ?>
  <script type="text/javascript" src="<?= BASE_URL ?>js/snow.js"></script>
<?php endif; ?>

<script type="text/javascript" src="<?= BASE_URL ?>js/app.js"></script>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-87706617-1', 'auto');
    ga('send', 'pageview');
</script>
</body>
</html>
