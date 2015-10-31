<?php

require_once('../model/DAO.class.php');

$nouvelle = $dao->getNouvelleFromId($id);

if ($nouvelle == NULL) {
    die("La nouvelle spécifiée n'existe pas");
}

$titre = $nouvelle->getTitre();
$description = $nouvelle->getDescription();
$image = $nouvelle->getImageLocale();
$url = $nouvelle->getUrl();
$date = $nouvelle->getDate();

include('../view/afficher_nouvelle.view.php');