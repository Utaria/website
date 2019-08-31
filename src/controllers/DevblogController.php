<?php

namespace UtariaV1;

class DevblogController extends Controller
{

    public function index($pageUser)
    {
        $perPage = 15;
        $page = 1;

        if (isset($pageUser) && is_numeric($pageUser))
            $page = $pageUser;

        $total = $this->DB->req("
			SELECT count(id) AS c FROM devblog_articles " .
            "WHERE NOT draft AND not removed AND date IS NOT NULL AND date <= NOW()"
        )[0]->c;
        $maxPage = max(1, ceil($total / $perPage));

        if ($page > $maxPage) redirect("devblog/page/$maxPage");
        if ($page < 1) redirect("devblog");


        $articles = $this->DB->req(
            "SELECT devblog_articles.id, title, date, devblog_categories.name FROM devblog_articles " .
            "JOIN players ON players.id = devblog_articles.author_id " .
            "JOIN devblog_categories ON devblog_categories.id = devblog_articles.category_id " .
            "WHERE NOT draft AND NOT removed AND date IS NOT NULL AND date <= NOW() " .
            "ORDER BY date DESC " .
            "LIMIT " . ($perPage * ($page - 1)) . ",$perPage"
        );

        $this->set(array(
            "articles" => $articles,
            "nbPage" => $perPage,
            "page" => $page,
            "maxPage" => $maxPage,
            "firstPage" => ($page == 1),
            "lastPage" => ($page == $maxPage)
        ));
    }

    public function article($slug)
    {
        if (empty($slug)) redirect("devblog/");

        if ($slug == "postcomment") {
            $this->postcomment();
            return;
        }

        $previewMode = getGet("preview") != null && getUser() != null && !empty(getUser()->adminRole);
        $articles = $this->DB->req(
            "SELECT devblog_articles.id, players.playername, title, content, date, views, draft, devblog_categories.name " .
            "FROM devblog_articles " .
            "JOIN players ON players.id = devblog_articles.author_id " .
            "JOIN devblog_categories ON devblog_categories.id = devblog_articles.category_id " .
            "WHERE NOT removed"
        );
        $article = null;

        foreach ($articles as $art)
            if (slugify($art->title) == $slug || /* Pour les liens des réseaux sociaux, on gère toujours l'ancien slug */ slugify($art->title, true) == $slug) {
                $article = $art;
                break;
            }

        if ($article == null) redirect("devblog");

        // Gestion de la date de l'article et du mode prévisualisation
        $dateArt = !is_null($article->date) ? strtotime($article->date) : PHP_INT_MAX;
        $dateNow = strtotime("now");
        $draft = !is_null($article->draft) && $article->draft;

        if (!$previewMode && ($draft || $dateArt > $dateNow)) redirect("devblog");
        if ($previewMode && $dateArt <= $dateNow)
            redirect("devblog/" . slugify($article->title));

        $comments = $this->DB->req(
            "SELECT devblog_comments.*, players.playername FROM devblog_comments 
			 JOIN players ON players.id = devblog_comments.player_id 
			 WHERE article_id = {$article->id}
			 ORDER BY date DESC"
        );

        if (!$previewMode) {
            $this->DB->save(array(
                "table" => "devblog_articles",
                "fields" => array("views" => ++$article->views),
                "where" => "id",
                "wherevalue" => $article->id
            ));
        }

        Config::$pageTitle = $article->title . " - Devblog Utaria";

        $this->set((object)array(
            "article" => $article,
            "comments" => $comments,
            "previewMode" => $previewMode,

            "url" => (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"
        ));
    }


    public function postcomment()
    {
        if (empty($_POST)) redirect("devblog");

        $articleId = (isset($_POST["articleId"])) ? $_POST["articleId"] : null;
        $playername = (isset($_POST["playername"])) ? $_POST["playername"] : null;
        $password = (isset($_POST["password"])) ? $_POST["password"] : null;
        $content = (isset($_POST["content"])) ? $_POST["content"] : null;
        $parentCommentId = (isset($_POST["parentCommentId"])) ? $_POST["parentCommentId"] : null;

        if ($articleId == null || $playername == null || $password == null || $content == null) redirect("devblog");

        $article = $this->DB->findFirst(array(
            "table" => "devblog_articles",
            "conditions" => array("id" => $articleId)
        ));

        if ($article == null || $article->draft) redirect("devblog");


        $player = $this->DB->findFirst(array(
            "table" => "players",
            "conditions" => array("playername" => $playername, "password" => sha1($password))
        ));

        if ($player == null || empty($player)) redirect("devblog/" . slugify($article->title) . "?err=1#postcomment");

        if ($parentCommentId == "-1" || $parentCommentId == "null")
            $parentCommentId = null;

        $this->DB->save(array(
            "table" => "devblog_comments",
            "fields" => array(
                "player_id" => $player->id,
                "article_id" => $article->id,
                "content" => addslashes(htmlentities($content)),
                "comment_parent_id" => $parentCommentId
            )
        ));

        redirect("devblog/" . slugify($article->title) . "#comments");
    }


    public function admin_articles()
    {
        if (getGet("data") != null) {
            $data = array();
            $articles = $this->DB->req(
                "SELECT devblog_articles.id AS article_id, 
				        devblog_articles.*, 
				        players.playername, 
				        devblog_categories.name AS category_name 
				FROM devblog_articles " .
                "JOIN players ON players.id = devblog_articles.author_id " .
                "JOIN devblog_categories ON devblog_categories.id = devblog_articles.category_id  " .
                "WHERE NOT removed"
            );

            foreach ($articles as $v) {
                $planifiedDate = (time() < strtotime($v->date));

                $trimedContent = trim(prepareForMeta($v->content, 110));
                if (empty($trimedContent)) $trimedContent = "<b><i>Pas de texte. Ne contient que des images !</i></b>";

                $actions = "";

                if ($v->draft || $planifiedDate)
                    $actions .= "<a href='" . BASE_URL . "devblog/" . slugify($v->title) . "?preview=true' target='_blank' title='Prévisualiser le contenu'><i class='fa fa-eye'></i></a>";
                else
                    $actions .= "<a href='" . BASE_URL . "devblog/" . slugify($v->title) . "?preview=true' target='_blank' title='Voir le contenu publié'><i class='fa fa-eye'></i></a>";

                $actions .= "&nbsp;&nbsp;<a href='article/" . $v->id . "/comments' title='Gérer les commentaires'><i class='fa fa-comments'></i></a>&nbsp;&nbsp;<a href='article/" . $v->article_id . "/edit' title='Editer'><i class='fa fa-pencil text-info'></i></a>&nbsp;&nbsp;<a href='article/" . $v->article_id . "/delete' onclick='return confirmDelete()' title='Supprimer'><i class='fa fa-times text-danger'></i></a>";

                $data[] = array(
                    "title" => $v->title,
                    "content" => $trimedContent,
                    "date" => ($v->date != null) ? $v->date : "Non publié",
                    "category" => $v->category_name,
                    "author" => $v->playername,
                    "views" => $v->views,
                    "state" => ($v->draft) ? "Brouillon" : (($planifiedDate) ? "Planifié" : "Publié"),
                    "actions" => $actions
                );
            }

            printJSON(array("aaData" => $data));
        }
    }

    public function admin_newarticle()
    {
        $this->admin_article(array(-1, "new"));
    }

    public function admin_article($params)
    {
        if (count($params) < 2) $this->_redirectToArticles();
        $articleId = intval($params[0]);
        $action = $params[1];

        $article = $this->DB->findFirst(array(
            "table" => "devblog_articles",
            "conditions" => array("id" => $articleId)
        ));
        if ($article == null && $action != "new") $this->_redirectToArticles();

        $categories = $this->DB->find(array("table" => "devblog_categories"));


        switch ($action) {
            case "new":
                $this->changeView('devblog/admin_article');
            case "edit":
                if (isPost()) {
                    $title = getPost("title");
                    $content = getPost("content");
                    $categoryId = getPost("category");

                    $publish = getPost("publish");
                    $publishType = getPost("publication");
                    $publishDate = getPost("publish_date");
                    $publishTime = getPost("publish_time");

                    if (empty($content)) {
                        setNotif("Le contenu de l'article ne peut pas être vide !", "error");
                        $this->_redirectToArticles();
                    }

                    $fields = array("content" => trim($content), "category_id" => $categoryId);

                    if ($publish == "on") {
                        if ($publishType == "now") {
                            $fields["date"] = date('Y-m-d G:i:s');
                            $fields["draft"] = "FALSE";
                        } else {
                            $fields["date"] = date('Y-m-d G:i:s', strtotime(preg_replace("/\//", "-", $publishDate) . $publishTime));
                            $fields["draft"] = "FALSE";
                        }
                    }

                    if ($action == "new") {
                        $fields["title"] = $title;
                        $fields["author_id"] = getUser()->id;
                    }

                    $saveArray = array(
                        "table" => "devblog_articles",
                        "fields" => $fields
                    );

                    if ($action == 'edit') {
                        $saveArray["where"] = "id";
                        $saveArray["wherevalue"] = $article->id;
                    }

                    $this->DB->save($saveArray);

                    if ($action == "edit")
                        setNotif("L'article '<b>{$article->title}</b>' vient d'être mis à jour !");
                    else
                        setNotif("L'article '<b>{$title}</b>' vient d'être créé !");

                    $this->_redirectToArticles();
                }
                break;
            case "comments":
                if (getGet("data") != null) {
                    $data = array();
                    $comments = $this->DB->req(
                        "SELECT devblog_comments.*, players.playername
						 FROM devblog_comments
						 JOIN players ON players.id = devblog_comments.player_id
						 WHERE article_id = {$article->id}"
                    );

                    foreach ($comments as $v) {
                        $data[] = array(
                            "id" => $v->id,
                            "content" => stripslashes($v->content),
                            "date" => $v->date,
                            "author" => $v->playername,
                            "parent_comment" => (($v->comment_parent_id == null) ? '-' : $v->comment_parent_id),
                            "actions" => "<b class='badge bg-danger'><i class='fa fa-times'></i> En développement</b>"
                        );
                    }

                    printJSON(array("aaData" => $data));
                }
                break;
            case "delete":
                $this->DB->save(array(
                    "table" => "devblog_articles",
                    "fields" => array("removed" => true),
                    "where" => "id",
                    "wherevalue" => $article->id
                ));

                setNotif("L'article '<b>{$article->title}</b>' a bien été supprimé !");
                $this->_redirectToArticles();
                break;
            default:
                $this->_redirectToArticles();
        }

        $this->set(array(
            "action" => $action,
            "categories" => $categories,
            "article" => $article
        ));
    }


    private function _redirectToArticles()
    {
        redirect(BASE_URL . ADMIN_PREFIX . "devblog/articles");
    }

}
