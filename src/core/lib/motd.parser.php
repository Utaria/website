<?php

class MotdParser
{

    private static $COLOR_CODES = array(
        '0' => "black",
        '1' => "darkblue",
        '2' => "darkgreen",
        '3' => "mediumturquoise",
        '4' => "darkred",
        '5' => "darkorchid",
        '6' => "#fa0",
        '7' => "silver",
        '8' => "dimgray",
        '9' => "blue",
        'a' => "lime",
        'b' => "cyan",
        'c' => "red",
        'd' => "magenta",
        'e' => "yellow",
        'f' => "white"
    );

    private static $STYLE_CODES = array(
        'k' => "magic",
        'l' => "bold",
        'm' => "line-through",
        'n' => "underline",
        'o' => "italic"
    );

    private function __construct()
    {
    }


    public static function motdToHtml($motd, $specialChar = '§')
    {
        $motd = MotdParser::unicodeString($motd, "UTF-8");
        $html = "<font style='color:gray'>";
        $chars = MotdParser::mbStringToArray($motd);

        $center = false;
        $color = "gray";
        $special = 0;


        for ($i = 0; $i < count($chars); $i++) {
            $char = $chars[$i];

            if ($char == $specialChar) {
                if ($i + 1 == count($chars)) continue;
                $i += 1;

                if (MotdParser::isValidColorCode($chars[$i]))
                    $color = MotdParser::getColorByCode($chars[$i]);

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
                }

                // Dans le cadre d'une couleur, on réinitialise les effets
                if ($chars[$i] >= 'a' && $chars[$i] <= 'f' || $chars[$i] >= '0' && $chars[$i] <= '9')
                    $special = 0;

                $specialStyle = "";
                if (($special & 1) != 0) $specialStyle .= "font-weight: bold;";
                if (($special & 4) != 0 && ($special & 8) != 0)
                    $specialStyle .= "text-decoration-line: underline line-through;";
                else {
                    if (($special & 4) != 0) $specialStyle .= "text-decoration-line: underline;";
                    if (($special & 8) != 0) $specialStyle .= "text-decoration-line: line-through;";
                }
                if (($special & 16) != 0) $specialStyle .= "font-style: italic;";

                $html .= "</font><font style='color:" . $color . ";" . $specialStyle . "'>";
            } else if ($char == "%") {
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
                else if ($char == "\n") $html .= "<br />";
                else                    $html .= $char;
            }
        }

        $html .= "</font>";
        if ($center) $html .= "</span>";
        return $html;
    }

    public static function htmlToMotd($html, $specialChar = '§')
    {
        $html = str_replace('&nbsp;', ' ', $html);
        $html = trim(str_replace('<br>', "\n", $html));
        $chars = MotdParser::mbStringToArray($html);
        $motd = "";

        var_dump($html);

        // Variable pour parser le HTML
        $baliseOff = 0;
        $newKeyword = false;
        $newMotdWord = false;
        $newLine = false;
        $newColor = false;
        $isLetter = false;
        $lastColor = null;
        $lastKeyword = "";
        $lastMotdWord = "";

        $color = MotdParser::getDefaultColor();
        $styles = array();

        // Forcer si besoin la récupération du dernier mot
        $chars[] = ' ';

        for ($i = 0; $i < count($chars); $i++) {
            $char = $chars[$i];
            $isLetter = preg_match("/\pL|'|[0-9]|\-/", $char);
            $isEmpty = ($char == ' ' || $char == "\n");

            // Nouveau balisage, on se décale d'un cran
            if ($char == '<') $baliseOff++;

            // Aucun balisage, on mets à jour l'état du mot courant
            if ($baliseOff == 0) {
                if ($isEmpty) $newMotdWord = true;
                else          $lastMotdWord .= $char;
            } // Sinon, on met à jour l'état du mot de clé de balise
            else {
                if ($isLetter) $lastKeyword .= $char;
                if (!$isLetter && !$newKeyword) $newKeyword = true;
            }

            // Gestion des mots clés dans les balises
            if (strlen($newKeyword) > 0 && $newKeyword && $baliseOff > 0) {
                if (ctype_xdigit($lastKeyword))
                    $lastKeyword = "#" . $lastKeyword;

                // Une couleur ?
                if (in_array($lastKeyword, MotdParser::getColors())) {
                    $color = $lastKeyword;
                    $newColor = true;
                }

                // Un style ?
                if (in_array($lastKeyword, MotdParser::getStyles()))
                    if (!in_array($lastKeyword, $styles))
                        $styles[] = $lastKeyword;
            }

            // Formatage du MOTD en fonction de la couleur et du style du HTML
            $isEndWord = ($baliseOff == 0 && $isEmpty) || ($baliseOff == 1 && $char == '<');

            if ($isEndWord && !empty($lastMotdWord)) {
                if ($lastColor != $color || !empty($styles) || $newColor || $newLine)
                    $motd .= $specialChar . MotdParser::getCodeByColor($color);

                if (!empty($styles))
                    foreach ($styles as $style)
                        $motd .= $specialChar . MotdParser::getCodebyStyle($style);

                $motd .= $lastMotdWord . (($char != '<') ? $char : '');
            }

            // Fin de ligne spécial
            if ($char == "\n" && empty($lastMotdWord)) $motd .= $char;

            // Fin de balise, on se décale d'un cran
            if ($char == '>') $baliseOff--;

            // On réinitialise le formatage en fin de mot (clé de balise et mot rédigé)
            if ($baliseOff > 0 && !$isLetter) {
                $lastKeyword = "";
                $newKeyword = false;
            }

            if ($isEndWord && !empty($lastMotdWord)) {
                $lastMotdWord = "";
                $lastColor = $color;
                $styles = array();

                $newMotdWord = false;
                $newColor = false;
                $newLine = false;
            }

            if ($char == "\n") $newLine = true;
        }

        return html_entity_decode(trim($motd));
    }

    public static function getColors()
    {
        return array_values(MotdParser::$COLOR_CODES);
    }

    public static function getStyles()
    {
        return array_values(MotdParser::$STYLE_CODES);
    }

    public static function getColorByCode($code)
    {
        return isset(MotdParser::$COLOR_CODES[$code]) ? MotdParser::$COLOR_CODES[$code] : null;
    }

    public static function isValidColorCode($code)
    {
        return isset(MotdParser::$COLOR_CODES[$code]);
    }

    public static function getDefaultCode()
    {
        return '7';
    }

    public static function getDefaultColor()
    {
        return MotdParser::getColorByCode(MotdParser::getDefaultCode());
    }

    public static function getCodeByColor($color)
    {
        foreach (MotdParser::$COLOR_CODES as $code => $c)
            if ($c == $color)
                return $code;

        return MotdParser::getDefaultCode();
    }

    public static function getCodebyStyle($style)
    {
        foreach (MotdParser::$STYLE_CODES as $code => $s)
            if ($s == $style)
                return $code;

        return MotdParser::getDefaultCode();
    }


    private static function unicodeString($str, $encoding = null)
    {
        if (is_null($encoding)) $encoding = ini_get('mbstring.internal_encoding');
        return preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/u', create_function('$match', 'return mb_convert_encoding(pack("H*", $match[1]), ' . var_export($encoding, true) . ', "UTF-16BE");'), $str);
    }

    private static function str_replace_n($search, $replace, $subject, $occurrence)
    {
        $search = preg_quote($search);
        $search = str_replace("/", "\/", $search);

        $regex = "/^((?:(?:(?:.|\s)*?$search){" . (--$occurrence) . "}(?:.|\s)*?))$search/";

        return preg_replace($regex, "$1$replace", $subject);
    }

    private static function mbStringToArray($string)
    {
        $strlen = mb_strlen($string);
        $array = [];

        while ($strlen) {
            $array[] = mb_substr($string, 0, 1, "UTF-8");
            $string = mb_substr($string, 1, $strlen, "UTF-8");
            $strlen = mb_strlen($string);
        }

        return $array;
    }

}

?>
