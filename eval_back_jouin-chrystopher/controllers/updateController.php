<?php
// Config
// Models
require_once __DIR__  . '/../models/Links.php';

require_once __DIR__ . '/../helpers/sessionFlash/Sessionflash.php';

// Config
require_once __DIR__  . '/../config/regex.php';


try {
    $id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));
    $link = Links::read($id);

    // --------------------------------------------------------------------------------------------------
    // ----------------------------------FORMULAIRE------------------------------------------------
    // --------------------------------------------------------------------------------------------------
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // ---------------------------------------------
        // -------------------NETTOYAGE
        // ---------------------------------------------
        $title = trim(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS));
        $url = trim(filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL));

        // ---------------------------------------------
        // -------------------VALIDATION
        // ---------------------------------------------

        // Title
        if (empty($title)) {
            $error['title'] = 'Ce champ est obligatoire';
        } else if (strlen($title) <= 3) {
            $error['title'] = 'Votre titre est trop court';
        }

        // Url
        if (empty($url)) {
            $erorr['url'] =  'Ce champ est obligatoire';
        } else if (!filter_var($url, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/' . REGEX_URL_HTTPS . '/')))) {
            $error['url'] = 'L\'url n\'est pas conforme';
        }
        if (Links::readUrl($url)) {
            $erorr['url'] = 'Ce site est déjà dans notre base de données';
        }

        if (empty($error)) {
            // Instanciation de l'objet LINKS
            $link = new Links(
                $title,
                $url,
                $link->link_id
            );

            $linkIsCreated = $link->update($id);

            // Reponse de la requete / true ou false
            if (!$linkIsCreated) {
                $eror['add'] = 'Le liens n\'a pas pu être modifié';
            } else {
                SessionFlash::setMessage('Le lien a bien été modifié');
                header('Location: /controllers/formController.php');
                exit;
            }
        }
    }
} catch (\Throwable $th) {
    header('Location: /controllers/formController.php');
    die;
}


// -----------Include
include __DIR__ . './../views/layout/header.php';
if (!Links::readId($id)) {
    header('Location: /controllers/formController.php');
    exit;
} else {
    include __DIR__ . './../views/pages/updateLinks.php';
}
include __DIR__ . './../views/layout/footer.php';
