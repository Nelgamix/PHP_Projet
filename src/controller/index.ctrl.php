<?php

require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');
require_once('../../kint/Kint.class.php');

// Array de rss et d'url
$v_rss = array();
$v_url = array();

// Différents url des rss voulus
$v_url[] = 'http://www.lemonde.fr/m-actu/rss_full.xml';
$v_url[] = 'http://www.01net.com/rss/actualites/technos/';

// Récup de tous les RSS
foreach($v_url as $url) {
    $v_rss[] = $dao->readRSSfromURL($url);
}

// Mise à jour de tous les RSS
foreach($v_rss as $rss) {
    $rss->update();
}

if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
} else {
    $mode = 4;
}

$includeFile = '../controller/';

switch($mode) {
    case 1: // Mode: afficher une nouvelle bien particulière (necessite un id)
        $includeFile .= 'afficher_nouvelle.ctrl.php';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            $id = 1;
        }
        break;
    case 2: // Mode: afficher toutes les nouvelles correspondant à un flux (necessite un id)
        $includeFile .= 'afficher_nouvelles.ctrl.php';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            $id = 1;
        }
        break;
    case 3:
        $includeFile .= 'afficher_nouvelles_img.ctrl.php';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            $id = 1;
        }
        break;
    default: // Mode: afficher tous les url de flux
        $includeFile .= 'afficher_flux.ctrl.php';
}

include('../view/index.view.php');


