<?php

require_once('../model/DAO.class.php');

$rss = $dao->getRSSFromId($id);

if ($rss == NULL) {
    die("Le rss sp�cifi� n'existe pas");
}

include('../view/afficher_nouvelles.view.php');