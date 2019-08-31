<?php
function _config_($configKey)
{
    switch ($configKey) {
        case "maxplayers"         :
            return "Nombre maximal de joueurs";
        case "motd"               :
            return "Message du jour";
        case "maintenance"        :
            return "Mode maintenance";
        case "maintenance_motd"   :
            return "Message du jour de la maintenance";
        case "autorestart_hour"   :
            return "Heure de redémarrage du serveur";
        case "default_server"     :
            return "Serveur par défaut";
        case "disable_autorestart":
            return "Redémarrage automatique";
        case "default_rank"       :
            return "Grade par défaut";

        case "antibot_protection_enabled":
            return "Protection anti-bot active";
        case "socket_server_port_bungee" :
            return "Port du serveur UtariaBungee";
        case "socket_server_ip_bungee"   :
            return "IP du proxy principal";
        case "survie_coins_exchange_enabled" :
            return "Echange coins/pièce actif";

        default:
            return $configKey;
    }
}

function getInputType($configValue)
{
    if ($configValue == "true" || $configValue == "false") return "checkbox";
    if (is_numeric($configValue)) return "number";

    if (preg_match("/^([0-9]|0[0-9]|1[0-9]|2[0-3])[h:][0-5][0-9]$/", $configValue))
        return "time";

    return "text";
}

function unicodeString($str, $encoding = null)
{
    if (is_null($encoding)) $encoding = ini_get('mbstring.internal_encoding');
    return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/u', create_function('$match', 'return mb_convert_encoding(pack("H*", $match[1]), ' . var_export($encoding, true) . ', "UTF-16BE");'), $str);
}

function mbStringToArray($string)
{
    $strlen = mb_strlen($string);
    while ($strlen) {
        $array[] = mb_substr($string, 0, 1, "UTF-8");
        $string = mb_substr($string, 1, $strlen, "UTF-8");
        $strlen = mb_strlen($string);
    }
    return $array;
}

function motdToHtml($motd)
{
    $motd = unicodeString($motd, "UTF-8");
    $html = "<font style='color:gray'>";
    $chars = mbStringToArray($motd);

    $center = false;
    $color = "gray";
    $special = 0;


    for ($i = 0; $i < count($chars); $i++) {
        $char = $chars[$i];

        if ($char == "§") {
            if ($i + 1 == count($chars)) continue;
            $i += 1;

            switch ($chars[$i]) {
                case 'l':
                    $special |= 1;
                    break;
                case 'k':
                    $special |= 2;
                    break;
                case 'n':
                    $special |= 4;
                    break;
                case 'm':
                    $special |= 8;
                    break;
                case 'o':
                    $special |= 16;
                    break;
                case 'r':
                    $special = 0;
                    $color = "gray";
                    break;

                case '0':
                    $color = "black";
                    break;
                case '1':
                    $color = "darkblue";
                    break;
                case '2':
                    $color = "darkgreen";
                    break;
                case '3':
                    $color = "mediumturquoise";
                    break;
                case '4':
                    $color = "darkred";
                    break;
                case '5':
                    $color = "darkorchid";
                    break;
                case '6':
                    $color = "#fa0";
                    break;
                case '7':
                    $color = "silver";
                    break;
                case '8':
                    $color = "dimgray";
                    break;
                case '9':
                    $color = "blue";
                    break;
                case 'a':
                    $color = "lime";
                    break;
                case 'b':
                    $color = "cyan";
                    break;
                case 'c':
                    $color = "red";
                    break;
                case 'd':
                    $color = "magenta";
                    break;
                case 'e':
                    $color = "yellow";
                    break;
                case 'f':
                    $color = "white";
                    break;
            }

            $specialStyle = "";
            if (($special & 1) != 0) $specialStyle .= "font-weight: bold;";
            if (($special & 4) != 0) $specialStyle .= "text-decoration: underline;";
            if (($special & 8) != 0) $specialStyle .= "text-decoration: line-through;";
            if (($special & 16) != 0) $specialStyle .= "font-style: italic;";

            $html .= "</font><font style='color:" . $color . ";" . $specialStyle . "'>";
        } elseif ($char == "%") {
            if ($i + 2 >= count($chars)) continue;
            $symbol = $chars[++$i];
            $i++;

            $html .= "</font>";

            switch ($symbol) {
                case "c":
                    $center = true;
                    $html .= "<span style='text-align:center;display:block'>";
                    break;
                case "n":
                    if ($center) {
                        $html .= "</span>";
                        $center = false;
                    } else
                        $html .= "<br />";
                    break;
            }
        } else {
            if ($char == " ") $html .= "&nbsp;";
            else              $html .= $char;
        }
    }

    $html .= "</font>";
    if ($center) $html .= "</span>";
    return $html;
}

function htmlToMotd($html)
{
    return $html;
}

?>
<div class="app-content-body ">
  <div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Modifier la configuration de l'infrastructure</h1>
  </div>

  <div class="wrapper-md" ng-controller="FormModifConfigCtrl">
    <div class="panel panel-default">
      <div class="panel-heading font-bold">
        Configuration générale de l'infrastructure
      </div>
      <div class="panel-body">
        <form class="form-horizontal" method="post">
            <?php foreach ($d as $v): ?>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?= _config_($v->key); ?></label>
                <div class="col-sm-10">
                    <?php $type = getInputType($v->value); ?>

                    <?php if ($type == "text" || $type == "number"): ?>
                        <?php if (strpos($v->key, "motd") !== false): ?>
                        <div class="btn-toolbar m-b-sm btn-editor" data-role="editor-toolbar"
                             data-target="#editor_<?= $v->key ?>">
                          <div class="btn-group">
                            <a class="btn btn-default" data-edit="bold" tooltip="Gras (Ctrl/Cmd+B)"><i
                                  class="fa fa-bold"></i></a>
                            <a class="btn btn-default" data-edit="italic" tooltip="Italique (Ctrl/Cmd+I)"><i
                                  class="fa fa-italic"></i></a>
                            <a class="btn btn-default" data-edit="strikethrough" tooltip="Tressé"><i
                                  class="fa fa-strikethrough"></i></a>
                            <a class="btn btn-default" data-edit="underline" tooltip="Sous-ligné (Ctrl/Cmd+U)"><i
                                  class="fa fa-underline"></i></a>
                            <a class="btn btn-default" data-edit="magic" tooltip="Magique (Ctrl/Cmd+W)"><i
                                  class="fa fa-magic"></i></a>
                          </div>
                          <div class="btn-group dropdown" dropdown>
                            <a class="btn btn-default" dropdown-toggle data-toggle="dropdown"
                               tooltip="Couleur du texte"><i class="fa fa-text-height"></i>&nbsp;<b
                                  class="caret"></b></a>
                            <ul class="dropdown-menu">
                              <li><a data-edit="fontSize 5" style="font-size:24px">Huge</a></li>
                              <li><a data-edit="fontSize 3" style="font-size:18px">Normal</a></li>
                              <li><a data-edit="fontSize 1" style="font-size:14px">Small</a></li>
                            </ul>
                          </div>
                          <div class="btn-group">
                            <a class="btn btn-default" data-edit="undo" tooltip="Annuler (Ctrl/Cmd+Z)"><i
                                  class="fa fa-undo"></i></a>
                            <a class="btn btn-default" data-edit="redo" tooltip="Refaire (Ctrl/Cmd+Y)"><i
                                  class="fa fa-repeat"></i></a>
                          </div>
                        </div>
                        <div ui-jq="wysiwyg" id="editor_<?= $v->key ?>" class="form-control motd-edit-box"
                             contenteditable="true">
                            <?= motdToHtml($v->value) ?>
                        </div>
                        <?php else: ?>
                        <input type="<?= $type ?>" name="<?= $v->key ?>" class="form-control" value="<?= $v->value ?>">
                        <?php endif; ?>
                    <?php elseif ($type == "checkbox"): ?>
                        <?php if ($v->key == "disable_autorestart") $v->value = ($v->value == "true") ? "false" : "true"; ?>
                      <label class="i-switch i-switch-lg m-t-xs m-r">
                        <input name="<?= $v->key ?>"
                               type="checkbox"<?php if ($v->value == "true"): ?> checked<?php endif; ?>>
                        <i></i>
                      </label>
                    <?php elseif ($type == "time"): ?>
                      <input type="text" ui-jq="timepicker"
                             ui-options="{'timeFormat': 'H:i', 'step': 15, 'disableTimeRanges': [['10:00', '22:00']]}"
                             name="<?= $v->key ?>" class="form-control"
                             value="<?= preg_replace("/h/", ":", $v->value) ?>">
                    <?php endif; ?>
                </div>
              </div>
              <div class="line line-dashed b-b line-lg pull-in"></div>
            <?php endforeach; ?>

          <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
              <button type="reset" class="btn btn-default">Annuler</button>
              <button type="submit" class="btn btn-primary">Sauvegarder les modifications</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
