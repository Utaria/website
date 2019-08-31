<?php

namespace UtariaV1;

class IndexController extends Controller
{

    public function index()
    {
        // Not implemented
    }

    public function admin_index()
    {
        adminPrivatePage();

        //$onlinePlayers = file_get_contents('https://minecraft-api.com/api/ping/playeronline.php?ip=mc.utaria.fr&port=25565');
        //$maxPlayers = json_decode(file_get_contents(BASE_URL . "api/server/maxplayers"))->maxplayers;
        $onlinePlayers = 12;
        $maxPlayers = 50;

        $allPlayers = $this->DB->req("SELECT count(id) AS c from players")[0]->c;
        $nbPlayers = $this->DB->req(
            "SELECT count(id) AS c from players WHERE password IS NOT NULL"
        )[0]->c;
        /*$bannedPlayers = $this->DB->req(
            "SELECT count(id) AS c from bungee_bans
			 WHERE unban_date IS NULL AND ban_end IS NULL OR ban_end > NOW()"
        )[0]->c;*/
        $bannedPlayers = 0;
        $nbPlayersHour = $this->DB->req(
            "SELECT count(id) AS c from players
			 WHERE password IS NOT NULL and first_connection > NOW() - INTERVAL 1 HOUR"
        )[0]->c;

        $newPlayers = $this->DB->req(
            "SELECT count(id) AS c from players
			 WHERE password IS NOT NULL and DATE(first_connection) = DATE(NOW())"
        )[0]->c;
        $lastNewPlayers = $this->DB->req(
            "SELECT count(id) AS c from players
			 WHERE password IS NOT NULL and DATE(first_connection) = DATE(NOW()) - INTERVAL 1 DAY"
        )[0]->c;

        //$nbAchats = $this->DB->req("SELECT count(id) AS c from shop_log")[0]->c;
        //$nbAchatsToday = $this->DB->req("SELECT count(id) AS c from shop_log where date(ordertime) = date(now())")[0]->c;
        $nbAchats = 0;
        $nbAchatsToday = 0;

        $activePlayers = $this->DB->req(
            "SELECT count(id) AS c from players
			 WHERE last_connection >= NOW() - INTERVAL 1 MONTH"
        )[0]->c;
        /*$earnedThisMonth = $this->DB->req(
            "SELECT sum(price) AS sum FROM shop_log
			 JOIN shop_coins_products
			   ON shop_coins_products.id = shop_log.shop_coins_product_id
			 WHERE MONTH(ordertime) = MONTH(NOW());"
        )[0]->sum;*/
        $earnedThisMonth = 0;

        /*$staffMembers = $this->DB->req(
            "SELECT playername, name FROM players_ranks JOIN players ON players.id =
			 players_ranks.player_id JOIN ranks ON ranks.id = players_ranks.rank_id WHERE name
			 = 'Fondateur' OR name = 'Modérateur' OR name = 'Modérateur+' OR name = 'Helpeur'
			 ORDER BY level DESC"
        );*/

        $staffMembers = [];

        $statsFile = dirname(SRC) . DS . 'playerstats.txt';
        $dataStats = preg_split("/\\n/", file_get_contents($statsFile));
        $dataToday = array();
        $dataYest = array();

        $k = 0;
        $lastNb = -1;
        $today = date('d/m/Y');
        $yest = date('d/m/Y', strtotime("-1 days"));

        foreach ($dataStats as $v) {
            if (strpos($v, ":") === false) continue;
            $dataParts = preg_split("/:/", $v);
            $time = intval($dataParts[0]);
            $valDate = date('d/m/Y', $time);

            if ($valDate == $today || $valDate == $yest) {
                $nbPlayersData = intval($dataParts[1]);
                $nextNb = -1;

                if ($k + 1 < count($dataStats) - 1)
                    $nextNb = intval(preg_split("/:/", $dataStats[$k + 1])[1]);

                if ($lastNb != $nbPlayersData || $nextNb != $nbPlayersData)
                    if ($valDate == $today)
                        $dataToday[] = array($time * 1000, $nbPlayersData);
                    else
                        $dataYest[] = array($time * 1000, $nbPlayersData);

                $lastNb = $nbPlayersData;
            }

            $k++;
        }

        $lastNbPlayers = $dataToday[count($dataToday) - 1][1];

        $this->set((object)array(
            "onlinePlayers" => $onlinePlayers,
            "maxPlayers" => $maxPlayers,
            "lastNbPlayers" => $lastNbPlayers,
            "nbPlayers" => $nbPlayers,
            "nbPlayersHour" => $nbPlayersHour,

            "newPlayers" => $newPlayers,
            "lastNewPlayers" => $lastNewPlayers,

            "nbAchats" => $nbAchats,
            "nbAchatsToday" => $nbAchatsToday,

            "dataToday" => json_encode($dataToday),
            "dataYest" => json_encode($dataYest),

            "activePlayerPerc" => round(($activePlayers / $nbPlayers) * 100),
            "registPlayerPerc" => round(($nbPlayers / $allPlayers) * 100),
            "bannedPlayerPerc" => round(($bannedPlayers / $nbPlayers) * 100),
            "earnedMonthPerc" => round(($earnedThisMonth / 50) * 100),

            "staffMembers" => (object)$staffMembers
        ));
    }

}
