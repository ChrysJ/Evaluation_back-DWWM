<?php
// Config
// Config
require_once __DIR__  . '/../config/regex.php';

// Session falsh
require_once __DIR__ . '/../helpers/sessionFlash/Sessionflash.php';
// Class
require_once __DIR__  . '/../models/Links.php';




try {
    // Récupération des données
    $links = Links::readAll();

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
                $url
            );

            $linkIsCreated = $link->create();

            // Reponse de la requete / true ou false
            if (!$linkIsCreated) {
                $eror['add'] = 'Le liens n\'a pas pus être ajouté';
            } else {
                $error['add'] = 'Le liens a bien été ajouté, Merci pour votre contribution !';
                $links = Links::readAll();
            }
        }
    }
} catch (\Throwable $th) {
    header('Location: /controllers/formController.php');
    die;
}

// Metadescription
$metadescription = '<meta name="descripion" content="Ajoutez un lien a la liste des liens">';


// -----------Include
include __DIR__ . './../views/layout/header.php';
include __DIR__ . './../views/pages/form.php';
include __DIR__ . './../views/layout/footer.php';
