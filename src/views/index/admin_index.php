<div class="app-content-body ">

  <div class="hbox hbox-auto-xs hbox-auto-sm" ng-init="
	    app.settings.asideFolded = true;
	    app.settings.asideDock = true;
	  ">

    <!-- main -->
    <div class="col">
      <div class="bg-black dker wrapper-lg flotChartCtrl">
        <ul class="nav nav-pills nav-xxs nav-rounded m-b-lg">
          <li class="active" plot-data="<?= $d->dataToday ?>"><a href="#">Auj.</a></li>
          <li plot-data="<?= $d->dataYest ?>"><a href="#">Hier</a></li>
          <li><a href="#">Semaine</a></li>
          <li><a href="#">Mois</a></li>
        </ul>
        <div ui-jq="plot" ui-refresh="d0_1" ui-options="
	        [
	          { data: <?= $d->dataToday ?>, points: { show: true, radius: 2}, splines: { show: true, tension: 0.0001, lineWidth: 1 } }
	        ],
	        {
	          colors: ['#23b7e5', '#7266ba'],
	          series: { shadowSize: 3 },
	          xaxis:{ mode: 'time', timeformat: '%H:%M', timezone: 'browser', font: { color: '#507b9b' } },
	          yaxis:{ font: { color: '#507b9b' }, tickDecimals: 0 },
	          grid: { hoverable: true, clickable: true, borderWidth: 0, color: '#1c2b36' },
	          tooltip: true,
	          tooltipOpts: { content: '%y joueurs connectés à %x',  defaultTheme: false, shifts: { x: 10, y: -25 } }
	        }
	      " style="min-height:360px" class="plotChart">
        </div>
      </div>
        <?php
        function caretClass($var)
        {
            if ($var > 0) return "fa-caret-up text-success";
            else if ($var < 0) return "fa-caret-down text-danger";
            else               return "fa-caret-right text-primary";
        }

        ?>
      <div class="wrapper-md bg-white-only b-b">
        <div class="row text-center">
          <div class="col-sm-3 col-xs-6">
            <div>Joueurs <i class="fa fa-fw <?= caretClass($d->nbPlayersHour) ?> text-sm"></i></div>
            <div class="h2 m-b-sm"><?= $d->nbPlayers ?></div>
          </div>
          <div class="col-sm-3 col-xs-6">
            <div>Connectés <i class="fa fa-fw  <?= caretClass($d->onlinePlayers - $d->lastNbPlayers) ?> text-sm"></i>
            </div>
            <div class="h2 m-b-sm"><?= $d->onlinePlayers ?></div>
          </div>
          <div class="col-sm-3 col-xs-6">
            <div>Achats <i class="fa fa-fw <?= caretClass($d->nbAchatsToday) ?> text-sm"></i></div>
            <div class="h2 m-b-sm"><?= $d->nbAchats; ?></div>
          </div>
          <div class="col-sm-3 col-xs-6">
            <div>Nouveaux joueurs <i
                  class="fa fa-fw <?= caretClass($d->newPlayers - $d->lastNewPlayers) ?> text-sm"></i></div>
            <div class="h2 m-b-sm"><?= $d->newPlayers; ?></div>
          </div>
        </div>
      </div>
      <div class="wrapper-md">
        <div class="row text-center">
          <div class="col-sm-3 col-xs-6">
            <div>Joueurs connectés (avec mdp.)</div>
            <div ui-jq="easyPieChart" ui-options="{
	              percent: <?= $d->registPlayerPerc ?>,
	              lineWidth: 4,
	              trackColor: '#e8eff0',
	              barColor: '#7266ba',
	              scaleColor: false,
	              size: 115,
	              rotate: 90,
	              lineCap: 'butt'
	            }" class="inline m-t">
              <div>
                <span class="text-primary h3"><?= $d->registPlayerPerc ?>%</span>
              </div>
            </div>
          </div>
          <div class="col-sm-3 col-xs-6">
            <div>Joueurs actifs le dernier mois</div>
            <div ui-jq="easyPieChart" ui-options="{
	              percent: <?= $d->activePlayerPerc ?>,
	              lineWidth: 4,
	              trackColor: '#e8eff0',
	              barColor: '#23b7e5',
	              scaleColor: false,
	              size: 115,
	              rotate: 0,
	              lineCap: 'butt'
	            }" class="inline m-t">
              <div>
                <span class="text-info h3"><?= $d->activePlayerPerc ?>%</span>
              </div>
            </div>
          </div>
          <div class="col-sm-3 col-xs-6">
            <div>Joueurs actuellement bannis</div>
            <div ui-jq="easyPieChart" ui-options="{
	              percent: <?= $d->bannedPlayerPerc ?>,
	              lineWidth: 4,
	              trackColor: '#e8eff0',
	              barColor: '#fad733',
	              scaleColor: false,
	              size: 115,
	              rotate: 180,
	              lineCap: 'butt'
	            }" class="inline m-t">
              <div>
                <span class="text-warning h3"><?= $d->bannedPlayerPerc ?>%</span>
              </div>
            </div>
          </div>
          <div class="col-sm-3 col-xs-6">
            <div>Objectif financier mensuel</div>
            <div ui-jq="easyPieChart" ui-options="{
	              percent: <?= $d->earnedMonthPerc ?>,
	              lineWidth: 4,
	              trackColor: '#e8eff0',
	              barColor: '#27c24c',
	              scaleColor: false,
	              size: 115,
	              rotate: 90,
	              lineCap: 'butt'
	            }" class="inline m-t">
              <div>
                <span class="text-success h3"><?= $d->earnedMonthPerc ?>%</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="wrapper-md">
        <!-- users -->
          <?php
          function countMembers($members)
          {
              $i = 0;
              foreach ($members as $v) $i++;
              return $i;
          }

          function countForGrade($members, $rankName)
          {
              $i = 0;
              foreach ($members as $v)
                  if (strpos($v->name, $rankName) !== false)
                      $i++;
              return $i;
          }

          function getColorByGrade($rankName)
          {
              switch ($rankName) {
                  case "Fondateur":
                      return "danger";
                  case "Modérateur+":
                  case "Modérateur" :
                      return "success";
                  case "Helpeur":
                      return "info";

                  default:
                      return "primary";
              }
          }

          ?>
        <div class="row">
          <div class="col-md-6">
            <div class="panel no-border">
              <div class="panel-heading wrapper b-b b-light">
	              <span class="text-xs text-muted pull-right">
	                <i class="fa fa-circle text-danger m-r-xs"></i> <?= countForGrade($d->staffMembers, "Fondateur") ?>
	                <i class="fa fa-circle text-success m-r-xs m-l-sm"></i> <?= countForGrade($d->staffMembers, "Modérateur") ?>
	                <i class="fa fa-circle text-info m-r-xs m-l-sm"></i> <?= countForGrade($d->staffMembers, "Helpeur") ?>
	              </span>
                <h5 class="font-thin m-t-none m-b-none text-muted">Membres de l'équipe</h5>
              </div>
              <ul class="list-group list-group-lg m-b-none">
                  <?php foreach ($d->staffMembers as $k => $v): ?>
                    <li class="list-group-item">
                      <a href class="thumb-sm m-r">
                        <img src="https://minotar.net/avatar/<?= $v->playername ?>/64" class="r r-2x">
                      </a>
                      <span
                          class="pull-right label bg-<?= getColorByGrade($v->name); ?> inline m-t-sm"><?= $v->name ?></span>
                      <a href><?= $v->playername ?></a>
                    </li>
                      <?php if ($k > 3) break; ?>
                  <?php endforeach ?>
              </ul>
              <div class="panel-footer">
                <span class="pull-right badge badge-bg m-t-xs"><?= countMembers($d->staffMembers) ?> membres</span>
                <button class="btn btn-primary btn-addon btn-sm"><i class="fa fa-plus"></i>Ajouter un membre</button>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="list-group list-group-lg list-group-sp">
              <a href="<?= BASE_URL . ADMIN_PREFIX ?>/server/survie" class="list-group-item clearfix">
	        			<span class="pull-left thumb-sm avatar m-r">
	        				<img src="<?= BASE_URL ?>img/server/survie.png" alt="...">
                  <!-- <i class="on b-white right"></i> -->
	        			</span>
                <span class="clear">
	        				<span>Serveur survie</span>
	        				<small class="text-muted clear text-ellipsis">Cliquez pour afficher les infos du serveur</small>
	        			</span>
              </a>
              <!--  <a herf class="list-group-item clearfix">
                   <span class="pull-left thumb-sm avatar m-r">
                     <img src="img/a5.jpg" alt="...">
                     <i class="on b-white right"></i>
                   </span>
                   <span class="clear">
                     <span>Amanda Conlan</span>
                     <small class="text-muted clear text-ellipsis">Come online and we need talk about the plans that we have discussed</small>
                   </span>
                 </a>
                 <a herf class="list-group-item clearfix">
                   <span class="pull-left thumb-sm avatar m-r">
                     <img src="img/a6.jpg" alt="...">
                     <i class="busy b-white right"></i>
                   </span>
                   <span class="clear">
                     <span>Dan Doorack</span>
                     <small class="text-muted clear text-ellipsis">Hey, Some good news</small>
                   </span>
                 </a>
                 <a herf class="list-group-item clearfix">
                   <span class="pull-left thumb-sm avatar m-r">
                     <img src="img/a7.jpg" alt="...">
                     <i class="busy b-white right"></i>
                   </span>
                   <span class="clear">
                     <span>Lauren Taylor</span>
                     <small class="text-muted clear text-ellipsis">Nice to talk with you.</small>
                   </span>
                 </a>
                 <a herf class="list-group-item clearfix">
                   <span class="pull-left thumb-sm avatar m-r">
                     <img src="img/a8.jpg" alt="...">
                     <i class="away b-white right"></i>
                   </span>
                   <span class="clear">
                     <span>Mike Jackson</span>
                     <small class="text-muted clear text-ellipsis">This is nice</small>
                   </span>
               </a> -->
            </div>
          </div>
        </div>
        <!-- / users -->
      </div>
    </div>
    <!-- / main -->
    <!-- right col -->
    <div class="col w-md bg-black dk bg-auto">
      <div class="wrapper">
        <div class="m-b-sm text-md">Staff en ligne</div>
        <!-- <ul class="list-group no-bg no-borders pull-in">
            <li class="list-group-item">
              <a herf class="pull-left thumb-sm avatar m-r">
                <img src="img/a4.jpg" alt="..." class="img-circle">
                <i class="on b-white bottom"></i>
              </a>
              <div class="clear">
                <div><a href>Chris Fox</a></div>
                <small class="text-muted">Designer, Blogger</small>
              </div>
            </li>
            <li class="list-group-item active">
              <a herf class="pull-left thumb-sm avatar m-r">
                <img src="img/a5.jpg" alt="..." class="img-circle">
                <i class="on b-white bottom"></i>
              </a>
              <div class="clear">
                <div><a href>Mogen Polish</a></div>
                <small class="text-muted">Writter, Mag Editor</small>
              </div>
            </li>
            <li class="list-group-item">
              <a herf class="pull-left thumb-sm avatar m-r">
                <img src="img/a6.jpg" alt="..." class="img-circle">
                <i class="busy b-white bottom"></i>
              </a>
              <div class="clear">
                <div><a href>Joge Lucky</a></div>
                <small class="text-muted">Art director, Movie Cut</small>
              </div>
            </li>
            <li class="list-group-item">
              <a herf class="pull-left thumb-sm avatar m-r">
                <img src="img/a7.jpg" alt="..." class="img-circle">
                <i class="away b-white bottom"></i>
              </a>
              <div class="clear">
                <div><a href>Folisise Chosielie</a></div>
                <small class="text-muted">Musician, Player</small>
              </div>
            </li>
            <li class="list-group-item">
              <a herf class="pull-left thumb-sm avatar m-r">
                <img src="img/a8.jpg" alt="..." class="img-circle">
                <i class="away b-white bottom"></i>
              </a>
              <div class="clear">
                <div><a href>Aron Gonzalez</a></div>
                <small class="text-muted">Designer</small>
              </div>
            </li>
          </ul> -->
        <p>En développement...</p>
        <!-- <div class="text-center">
            <a href class="btn btn-sm btn-primary padder-md m-b">En savoir plus...</a>
          </div> -->
      </div>
    </div>
    <!-- / right col -->
  </div>

</div>
