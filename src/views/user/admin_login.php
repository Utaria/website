<a href="//utaria.fr" class="navbar-brand block m-t" style="padding:15px 0">
  <img src="/img/logo-dark.png" alt="Logo d'Utaria" style="max-height:72px">
</a>
<div class="m-b-lg">
  <div class="wrapper text-center">
    <strong>Espace réservé, connectez-vous pour continuer.</strong>
  </div>
  <form name="form" method="POST" class="form-validation">
    <div class="text-danger wrapper text-center">
        <?php if (!empty($d)): ?>
          <b><i class="fa fa-warning"></i> <?= $d ?></b>
        <?php endif; ?>
    </div>
    <div class="list-group list-group-sm">
      <div class="list-group-item">
        <input type="text" placeholder="Nom de joueur" name="playername" class="form-control no-border" required>
      </div>
      <div class="list-group-item">
        <input type="password" placeholder="Mot de passe sur le serveur" name="password" class="form-control no-border"
               required>
      </div>
    </div>
    <button type="submit" class="btn btn-lg btn-primary btn-block">
      Connexion
    </button>
    <!--		 <div class="text-center m-t m-b"><a ui-sref="access.forgotpwd">Mot de passe oublié?</a></div>-->
    <div class="line line-dashed"></div>
    <!--		 <p class="text-center"><small>Vous n'avez pas de compte?</small></p>-->
    <!--		 <a ui-sref="access.signup" class="btn btn-lg btn-default btn-block">Créer un compte</a>-->
  </form>
</div>
<div class="text-center">
  <p>
    <small class="text-muted">Un panel développé avec <i class="fa fa-heart"></i> par Utarwyn pour <b>UTARIA</b><br>Soumis
      aux <a href="//boutique.utaria.fr/conditions/generales" target="_blank" title="Conditions d'UTARIA">conditions</a>
      - <?= date('Y') ?></small>
  </p>
</div>
