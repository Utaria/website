<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title><?= UtariaV1\Config::$pageTitle; ?></title>

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>

  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="viewport" content="width=device-width,initial-scale = 1, user-scalable = no">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <link rel="apple-touch-icon" href="/img/iosapp-icon.png"/>
  <link rel="icon" type="image/png" href="/img/favicon.png"/>

  <link rel="stylesheet" type="text/css" href="/css/admin/animate.css">
  <link rel="stylesheet" type="text/css" href="/css/admin/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="/css/admin/simple-line-icons.css">
  <link rel="stylesheet" type="text/css" href="/css/admin/bootstrap.css">

  <link rel="stylesheet" type="text/css" href="/css/admin/app.min.css">

    <?php if (hasNotif()): ?>
      <link rel="stylesheet" type="text/css" href="/css/admin/alertify.css">
    <?php endif; ?>
</head>
<body>

<div class="app app-header-fixed ">
    <?php if ($page != "user/admin_login"): ?>
      <!-- header -->
      <header id="header" class="app-header navbar" role="menu">
        <!-- navbar header -->
        <div class="navbar-header bg-dark">
          <button class="pull-right visible-xs dk" ui-toggle-class="show" target=".navbar-collapse">
            <i class="glyphicon glyphicon-cog"></i>
          </button>
          <button class="pull-right visible-xs" ui-toggle-class="off-screen" target=".app-aside" ui-scroll="app">
            <i class="glyphicon glyphicon-align-justify"></i>
          </button>
          <!-- brand -->
          <a href="<?= BASE_URL . ADMIN_PREFIX ?>" class="navbar-brand text-lt">
            <img src="/img/white-favicon.png" alt="." style="max-height:36px">
            <span class="hidden-folded m-l-xs">Utaria</span>
          </a>
          <!-- / brand -->
        </div>
        <!-- / navbar header -->

        <!-- navbar collapse -->
        <div class="collapse pos-rlt navbar-collapse box-shadow bg-white-only">
          <!-- buttons -->
          <div class="nav navbar-nav hidden-xs">
            <a href="#" class="btn no-shadow navbar-btn" ui-toggle-class="app-aside-folded" target=".app">
              <i class="fa fa-dedent fa-fw text"></i>
              <i class="fa fa-indent fa-fw text-active"></i>
            </a>
            <a href="#" class="btn no-shadow navbar-btn" ui-toggle-class="show" target="#aside-user">
              <i class="icon-user fa-fw"></i>
            </a>
          </div>
          <!-- / buttons -->

          <!-- nabar right -->
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown">
							<span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
								<img src="https://minotar.net/avatar/<?= getUser()->playername ?>/64" alt="...">
								<i class="on md b-white bottom"></i>
							</span>
                <span class="hidden-sm hidden-md"><?= getUser()->playername ?></span> <b class="caret"></b>
              </a>
              <!-- dropdown -->
              <ul class="dropdown-menu animated fadeInRight w">
                <li class="wrapper b-b m-b-sm bg-light m-t-n-xs">
                  <div>
                    <p>Niveau 42</p>
                  </div>
                  <div class="progress progress-xs m-b-none dker">
                    <div class="progress-bar progress-bar-info" data-toggle="tooltip" data-original-title="2%"
                         style="width:42%"></div>
                  </div>
                </li>
                <!-- <li>
                                  <a href>
                                      <span class="badge bg-danger pull-right">30%</span>
                                      <span>Paramètres</span>
                                  </a>
                              </li> -->
                <li>
                  <a href="<?= BASE_URL . ADMIN_PREFIX ?>/user" ui-sref="app.page.profile">Profil</a>
                </li>
                <!-- 	<li>
                                    <a ui-sref="app.docs">
                                        <span class="label bg-info pull-right">new</span>
                                        Aide
                                    </a>
                                </li> -->
                <li class="divider"></li>
                <li>
                  <a href="<?= BASE_URL . ADMIN_PREFIX ?>/user/logout" ui-sref="access.signin">Déconnexion</a>
                </li>
              </ul>
              <!-- / dropdown -->
            </li>
          </ul>
          <!-- / navbar right -->
        </div>
        <!-- / navbar collapse -->
      </header>
      <!-- / header -->

      <!-- aside -->
      <aside id="aside" class="app-aside hidden-xs bg-dark">
        <div class="aside-wrap">
          <div class="navi-wrap">
            <!-- user -->
            <div class="clearfix hidden-xs text-center hide" id="aside-user">
              <div class="dropdown wrapper">
                <a href="app.page.profile">
								<span class="thumb-lg w-auto-folded avatar m-t-sm">
									<img src="https://minotar.net/avatar/<?= getUser()->playername ?>/128" class="img-full" alt="...">
								</span>
                </a>
                <a href="#" data-toggle="dropdown" class="dropdown-toggle hidden-folded">
								<span class="clear">
									<span class="block m-t-sm">
										<strong class="font-bold text-lt"><?= getUser()->playername ?></strong>
										<b class="caret"></b>
									</span>
									<span class="text-muted text-xs block">Membre du staff</span>
								</span>
                </a>
                <!-- dropdown -->
                <ul class="dropdown-menu animated fadeInRight w hidden-folded">
                  <li class="wrapper b-b m-b-sm bg-info m-t-n-xs">
                    <span class="arrow top hidden-folded arrow-info"></span>
                    <div>
                      <p>Niveau 42</p>
                    </div>
                    <div class="progress progress-xs m-b-none dker">
                      <div class="progress-bar bg-white" data-toggle="tooltip" data-original-title="2%"
                           style="width:42%"></div>
                    </div>
                  </li>
                  <!-- 	<li>
                                        <a href>Paramètres</a>
                                    </li> -->
                  <li>
                    <a href="<?= BASE_URL . ADMIN_PREFIX ?>/user" ui-sref="app.page.profile">Profil</a>
                  </li>
                  <!-- <li>
                                      <a href>
                                          <span class="badge bg-danger pull-right">0</span>
                                          Notifications
                                      </a>
                                  </li> -->
                  <li class="divider"></li>
                  <li>
                    <a href="<?= BASE_URL . ADMIN_PREFIX ?>/user/logout">Déconnexion</a>
                  </li>
                </ul>
                <!-- / dropdown -->
              </div>
              <div class="line dk hidden-folded"></div>
            </div>
            <!-- / user -->

            <!-- nav -->
            <nav ui-nav class="navi clearfix">
              <ul class="nav">
                  <?php
                  function activeLink($page, $linkPage)
                  {
                      if (strpos($page, $linkPage) !== false)
                          return ' class="active"';
                      else
                          return "";
                  }

                  ?>
                  <?php if (getUser()->adminRole == "admin"): ?>
                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                      <span>Général</span>
                    </li>
                    <li<?= activeLink($page, "index/admin_index"); ?>>
                      <a href="<?= BASE_URL . ADMIN_PREFIX ?>">
                        <i class="glyphicon glyphicon-stats icon text-primary-dker"></i>
                        <span class="font-bold">Etat du serveur</span>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <b class="badge bg-danger pull-right">B</b>
                        <i class="glyphicon glyphicon-envelope icon text-info-lter"></i>
                        <span class="font-bold">Email</span>
                      </a>
                    </li>
                    <li class="line dk"></li>

                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                      <span>Serveur</span>
                    </li>

                    <li<?= activeLink($page, "tools/admin_feedbacks"); ?>>
                      <a href="<?= BASE_URL . ADMIN_PREFIX ?>/tools/feedbacks">
                        <i class="glyphicon glyphicon-retweet"></i>
                        <span>Retours des joueurs</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?= BASE_URL . ADMIN_PREFIX ?>/survie/economie">
                        <i class="glyphicon glyphicon-usd"></i>
                        <span>Economie</span>
                      </a>
                    </li>
                    <li<?= activeLink($page, "shop/") ?>>
                      <a href class="auto">
										<span class="pull-right text-muted">
											<i class="fa fa-fw fa-angle-right text"></i>
											<i class="fa fa-fw fa-angle-down text-active"></i>
										</span>
                        <i class="glyphicon glyphicon-transfer"></i>
                        <span>Boutique</span>
                      </a>
                      <ul class="nav nav-sub dk">
                        <li class="nav-sub-header">
                          <a href>
                            <span>Boutique</span>
                          </a>
                        </li>
                        <li<?= activeLink($page, "shop/admin_history") ?>>
                          <a href="<?= BASE_URL . ADMIN_PREFIX ?>/shop/history">
                            <span>Historique</span>
                          </a>
                        </li>
                        <li<?= activeLink($page, "shop/admin_paysafecards") ?>>
                          <a href="<?= BASE_URL . ADMIN_PREFIX ?>/shop/paysafecards">
                              <?php //$notValidated = $DB->req("SELECT COUNT(id) AS c FROM shop_paysafe_codes WHERE NOT VALIDATED")[0]->c; ?>
                              <?php $notValidated = 0 ?>
                              <?php if ($notValidated > 0): ?>
                                <b class="badge bg-danger pull-right"><?= $notValidated ?></b>
                              <?php endif; ?>
                            <span>Cartes Paysafe</span>
                          </a>
                        </li>
                      </ul>
                    </li>
                    <li<?= activeLink($page, "tools/"); ?>>
                      <a href class="auto">
										<span class="pull-right text-muted">
											<i class="fa fa-fw fa-angle-right text"></i>
											<i class="fa fa-fw fa-angle-down text-active"></i>
										</span>
                        <i class="glyphicon glyphicon-bookmark"></i>
                        <span>Outils</span>
                      </a>
                      <ul class="nav nav-sub dk">
                        <li class="nav-sub-header">
                          <a href>
                            <span>Outils</span>
                          </a>
                        </li>
                        <li<?= activeLink($page, "tools/admin_priceitemchanger"); ?>>
                          <a href="<?= BASE_URL . ADMIN_PREFIX ?>/tools/priceitemchanger">
                            <span>Modif. prix item</span>
                          </a>
                        </li>
                        <!-- <li>
											<a href="<?= BASE_URL . ADMIN_PREFIX ?>/tools/multiple-accounts">
												<span>Double-comptes</span>
											</a>
										</li> -->
                        <li<?= activeLink($page, "tools/admin_automessage"); ?>>
                          <a href="<?= BASE_URL . ADMIN_PREFIX ?>/tools/automessages">
                            <span>Messages auto.</span>
                          </a>
                        </li>
                        <li<?= activeLink($page, "tools/admin_modifconfig"); ?>>
                          <a href="<?= BASE_URL . ADMIN_PREFIX ?>/tools/modifconfig">
                            <span>Configuration</span>
                          </a>
                        </li>
                      </ul>
                    </li>

                    <li class="line dk hidden-folded"></li>

                  <?php endif; ?>

                  <?php if (getUser()->adminRole == "admin" || getUser()->adminRole == "redactor"): ?>

                    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                      <span>Site internet</span>
                    </li>
                    <li<?= activeLink($page, "devblog/"); ?>>
                      <a href class="auto">
										<span class="pull-right text-muted">
											<i class="fa fa-fw fa-angle-right text"></i>
											<i class="fa fa-fw fa-angle-down text-active"></i>
										</span>
                        <i class="glyphicon glyphicon-book"></i>
                        <span>Blog de dév.</span>
                      </a>
                      <ul class="nav nav-sub dk">
                        <li class="nav-sub-header">
                          <a href>
                            <span>Blog de dév.</span>
                          </a>
                        </li>
                        <li<?= activeLink($page, "devblog/admin_article"); ?>>
                          <a href="<?= BASE_URL . ADMIN_PREFIX ?>/devblog/articles">
                            <span>Articles</span>
                          </a>
                        </li>
                        <li<?= activeLink($page, "devblog/admin_newarticle"); ?>>
                          <a href="<?= BASE_URL . ADMIN_PREFIX ?>/devblog/newarticle">
                            <span>Nouvel article</span>
                          </a>
                        </li>
                      </ul>
                    </li>

                  <?php endif; ?>

                <li class="line dk hidden-folded"></li>

                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                  <span>Votre espace</span>
                </li>
                <li<?= activeLink($page, "user") ?>>
                  <a href="<?= BASE_URL . ADMIN_PREFIX ?>/user">
                    <i class="icon-user icon text-success-lter"></i>
                    <span>Profil</span>
                  </a>
                </li>
                <li<?= activeLink($page, "documents") ?>>
                  <a href="<?= BASE_URL . ADMIN_PREFIX ?>/documents">
                    <b class="badge bg-danger pull-right">New</b>
                    <i class="icon-question icon"></i>
                    <span>Documents</span>
                  </a>
                </li>
              </ul>
            </nav>
            <!-- nav -->
          </div>
        </div>
      </aside>
      <!-- / aside -->


      <!-- content -->
      <div id="content" class="app-content" role="main">
          <?= $content_for_layout ?>

        <!-- footer -->
        <footer id="footer" class="app-footer" role="footer">
          <div class="wrapper b-t bg-light">
            <span class="pull-right"><?= VERSION ?> <a href class="m-l-sm text-muted"><i
                    class="fa fa-long-arrow-up"></i></a></span>
            &copy;<?= date('Y') ?> Panel UTARIA, par Utarwyn.
          </div>
        </footer>
        <!-- / footer -->
      </div>

    <?php else: ?>
        <?php if (getUser()): redirect(BASE_URL . ADMIN_PREFIX); endif; ?>
      <div class="container w-xxl w-auto-xs">
          <?= $content_for_layout ?>
      </div>
    <?php endif; ?>

</div>


<script type="text/javascript" src="/js/admin/standalone.js?v=<?= time() ?>"></script>
<script type="text/javascript" src="/js/admin/app.min.js?v=<?= time() ?>"></script>
<script type="text/javascript" src="/js/admin/custom.js?v=<?= time() ?>"></script>

<?php if (hasNotif()): $notif = getNotif(); ?>
  <script type="text/javascript" src="/js/admin/alertify.js?v=<?= time() ?>"></script>
  <script type="text/javascript">
      (function () {
          alertify.logPosition("bottom right").theme("bootstrap").<?= $notif->type ?>("<?= stripslashes($notif->message) ?>", null);
      }());
  </script>
<?php endif; ?>

</body>
</html>
