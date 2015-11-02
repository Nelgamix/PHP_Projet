<?php

require_once('../model/DAO.class.php');

if ($id == 0) {
    $v_rss = $dao->constructAllRSS();
    foreach ($v_rss as $rss) {
        foreach ($rss->getNouvelles() as $k => $val) {
            if (strpos($val->getTitre(), $search) === false && strpos($val->getDescription(), $search) === false) {
                $rss->deleteNouvelle($k);
            }
        }
    }
} else {
    $v_rss[0] = $dao->constructRSS($id);
}

if (empty($v_rss)) {
    die("Le rss spécifié n'existe pas");
}

include('../view/afficher_nouvelles.view.php');