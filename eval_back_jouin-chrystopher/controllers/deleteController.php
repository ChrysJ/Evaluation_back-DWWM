<?php

require_once(__DIR__ . '/../models/Links.php');

try {
    // Nettoyage de l'id du patient passé en GET dans l'url
    $id = intval(trim(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)));

    // Delete links
    $result = Links::delete($id);

    if ($result === true) {
        SessionFlash::setMessage('Le lien a bien été supprimé');
    } else {
        SessionFlash::setMessage('Un problème est survenu lors de la suppression du lien');
    }
} catch (\Throwable $th) {
    header('Location: /controllers/formController.php');
    die;
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
