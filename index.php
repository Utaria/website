<?php
require_once 'core/config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="description" content="<?= Config::$description ?>">
	<meta name="keywords" content="minecraft,serveur minecraft,serveur,survie unique,unique,original,nouveau,survival">
	<meta name="author" content="Utaria">
	<meta name="dcterms.rightsHolder" content="utaria">
	<meta name="Revisit-After" content="2 days">
	<meta name="Rating" content="general">
	<meta name="language" content="fr-FR" />
	<meta name="robots" content="all" />
	<meta charset="UTF-8">

	<title>Utaria | Serveur Minecraft innovant</title>

	<meta name="viewport" content="width=device-width, initial-scale = 1, user-scalable = no">

    <meta name="twitter:card" content="summary">
	<meta name="twitter:site" content="@Utaria_FR">
	<meta name="twitter:title" content="Utaria, les serveurs de demain !">
	<meta name="twitter:description" content="Utaria, un serveur Minecraft innovant.">
	<meta property="og:title" content="Utaria">
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://utaria.fr/">

	<link rel="icon" type="image/png" href="./img/favicon.png" />

	<link href="https://fonts.googleapis.com/css?family=Lato|Open+Sans:400,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="./css/style.min.css">
</head>
<body>

	<header>
		<div class="main-bar row-container">
			<div class="left">
				<a href="https://utaria.fr/" title="Utaria, les serveurs de demain !"><div id="logo"></div></a>
			</div>
			<div class="right">
				<nav class="primary-menu">
					<a href="https://boutique.utaria.fr/" target="_blank" title="La boutique d'Utaria"><div class="item special-2">Boutique</div></a>
					<a href="https://feedback.utaria.fr/" target="_blank" title="Poster un avis dès maintenant"><div class="item">Poster un avis</div></a>
					<a href="https://serveurs-minecraft.com/serveur-minecraft?Classement=Utaria" target="_blank" rel="nofollow" title="Voter pour nous"><div class="item">Voter</div></a>
				</nav>
			</div>
		</div>

		<div class="clear"></div>
	</header>


	<section id="main">
		<h1 class="hero-1">Préparez - vous</h1>
		<h1 class="hero-2">à jouer sur un serveur innovant</h1>

		<p>Un nouveau monde survie unique et équilibré, un mode PVP dynamique et addictif, et bien plus.</p>
		<h2 class="hero-3">Connectez-vous via <span class="open-date">mc.utaria.fr</span></h2>
		<span class="online"><?= file_get_contents('https://serveurs-minecraft.com/api?Classement=Utaria&Joueurs_En_Ligne') ?> / <?= file_get_contents('https://serveurs-minecraft.com/api?Classement=Utaria&Slots') ?> joueurs connectés</span>
	</section>


	<footer>
		<div class="left">
			<p>
				Pour suivre les nouveautés :&nbsp;&nbsp; <a href="https://twitter.com/Utaria_FR" class="twitter-follow-button" data-lang="fr" data-show-count="false">Suivre @Utaria_FR</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
			</p>
		</div>
		<div class="center">
			<span class="copyright">Utaria n'est pas affilié à Mojang.<br>Site internet par <b>Utarwyn</b>.</span>
		</div>
		<div class="right">
			<!-- <a href="#" title="Conditions générales">Conditions générales</a>
			<a href="#" title="Mentions légales">Mentions légales</a> -->
			<a href="https://serveurs-minecraft.com/serveur-minecraft.php?Classement=Utaria" style="font-size:0.7em" target="_BLANK" rel="nofollow" title="serveurs-minecraft.com">
				Votez pour nous sur serveurs-minecraft.com
			</a>&nbsp;-&nbsp;
			<a href="http://www.serveurs-minecraft.org/vote.php?id=49236" style="font-size:0.7em" target="_BLANK" rel="nofollow" title="serveurs-minecraft.org">
				Votez pour nous sur serveurs-minecraft.org
			</a>&nbsp;-&nbsp;
			<a href="http://www.topminecraft.fr/vote.php?id=4348" style="font-size:0.7em" target="_BLANK" rel="nofollow" title="topminecraft.fr">
				Votez pour nous sur topminecraft.fr
			</a>
			<!-- <a href="http://www.topminecraft.fr/vote.php?id=4348">Voter pour Utaria</a> sur <a href="http://www.topminecraft.fr/" title="top minecraft">TopMinecraft.fr</a> -->
		</div>
	</footer>


	<script type="text/javascript" src="./js/snow.js"></script>
	<script type="text/javascript" src="./js/app.js"></script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-87706617-1', 'auto');
	  ga('send', 'pageview');

	</script>

</body>
</html>