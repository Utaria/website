<?php

namespace UtariaV1;

class DocumentsController extends Controller
{

    private $BASE_DIR = "/home/ftp/utariafr/www/admindoc/";

    public function admin_index()
    {
        if (getGet("data") != null) {
            $data = array();
            $docs = $this->DB->find(array("table" => "admin_documents"));

            foreach ($docs as $doc) {
                $author = $this->DB->findFirst(array(
                    "table" => "players",
                    "conditions" => array("id" => $doc->modified_by)
                ));

                $data[] = array(
                    "name" => $doc->name,
                    "creation_time" => date('Y-m-d', strtotime($doc->creation_time)),
                    "modification_time" => date('Y-m-d', strtotime($doc->modification_time)),
                    "modified_by" => $author->playername,
                    "access_link" => ((!file_exists($this->BASE_DIR . "{$doc->id}.pdf")) ? '<b>Indisponible</b>' : '<a href="' . BASE_URL . ADMIN_PREFIX . '/documents/view/' . $doc->id . '-' . slugify($doc->name) . '" target="_blank" style="color:#2980b9;font-weight:bold">Cliquez ici</a>')
                );
            }

            printJSON(array("aaData" => $data));
        }
    }

    public function admin_view($params)
    {
        if (empty($params)) redirect(BASE_URL . ADMIN_PREFIX . "/documents");
        $slug = $params[0];

        if (!strpos($slug, "-")) redirect(BASE_URL . ADMIN_PREFIX . "/documents");
        $parts = explode("-", $slug, 2);
        if (!is_numeric($parts[0])) redirect(BASE_URL . ADMIN_PREFIX . "/documents");

        $id = intval($parts[0]);
        $slug = $parts[1];
        $document = $this->DB->findFirst(array(
            "table" => "admin_documents",
            "conditions" => array("id" => $id)
        ));

        // Redirection vers le bon slug
        $realSlug = slugify($document->name);
        if ($realSlug != $slug)
            redirect(BASE_URL . ADMIN_PREFIX . "/documents/view/{$document->id}-{$realSlug}");

        if (empty($document)) redirect(BASE_URL . ADMIN_PREFIX . "/documents");

        $file = $this->BASE_DIR . "{$document->id}.pdf";

        if (!file_exists($file)) redirect(BASE_URL . ADMIN_PREFIX . "/documents");

        // On enregistre la vue de l'utilisateur en base de données
        $this->DB->save(array(
            "table" => "admin_documents_views",
            "fields" => array(
                "player_id" => getUser()->id,
                "document_id" => $document->id
            )
        ));

        header("Content-Type: application/pdf");
        readfile($file);
        die();
    }

    public function admin_admin()
    {
        if (getGet("data") != null) {
            $data = array();
            $docs = $this->DB->find(array("table" => "admin_documents"));
            $views = $this->DB->req(
                "SELECT document_id, playername, date FROM admin_documents_views
    			 JOIN players ON players.id = admin_documents_views.player_id"
            );

            foreach ($docs as $doc) {
                $docViews = array();

                foreach ($views as $view)
                    if ($view->document_id == $doc->id)
                        if (!in_array($view->playername, $docViews))
                            $docViews[] = $view->playername;

                $data[] = array(
                    "name" => $doc->name,
                    "viewed_by" => ((empty($docViews)) ? "Personne" : implode(", ", $docViews)),
                    "modification_time" => date('Y-m-d', strtotime($doc->modification_time)),
                    "actions" => "<a href='" . BASE_URL . ADMIN_PREFIX . "/documents/updatedoc/" . $doc->id . "' title='Soumettre une modification' style='color:#27ae60;font-size:1.2em'><i class='fa fa-plus-circle'></i></a><a href='" . BASE_URL . ADMIN_PREFIX . "/documents/deletedoc/" . $doc->id . "' title='Supprimer le document' style='padding-left:10px;color:#c0392b;font-size:1.2em'><i class='fa fa-times'></i></a>"
                );
            }

            printJSON(array("aaData" => $data));
        }
    }

    public function admin_updatedoc($params)
    {
        if (empty($params))
            redirect(BASE_URL . ADMIN_PREFIX . "/documents/admin");

        $id = $params[0];
        $document = $this->DB->findFirst(array(
            "table" => "admin_documents",
            "conditions" => array("id" => $id)
        ));

        if (empty($document))
            redirect(BASE_URL . ADMIN_PREFIX . "/documents/admin");

        if (isPost()) {
            if (empty($_SESSION["last_file"])) {
                setNotif("Le document n'a pas été envoyé au serveur !", "error");
                redirect(BASE_URL . ADMIN_PREFIX . "/documents/admin");
            }

            $this->DB->req(
                "UPDATE admin_documents SET modification_time = NOW(), modified_by = " . getUser()->id . " WHERE id = " . $document->id
            );

            setNotif("Le document a bien été mis à jour !");
            redirect(BASE_URL . ADMIN_PREFIX . "/documents/admin");
        }

        unset($_SESSION["last_file"]);

        if (getGet("post") != null) {
            $file = isset($_FILES["file"]) ? $_FILES["file"] : null;
            if (is_null($file)) die("Erreur interne.");

            if (move_uploaded_file($file["tmp_name"], "/home/ftp/utariafr/www/admindoc/" . $document->id . ".pdf"))
                $_SESSION["last_file"] = $file;

            die();
        }

        $this->set($document);
    }

}

?>
