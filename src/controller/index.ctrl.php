<?php
require_once('../model/DAO.class.php');
require_once('../model/RSS.class.php');
include_once('session.ctrl.php');

$titrePrincipal = "Projet M3104 - Programmation sur serveur web";

if (isset($_GET['search']) && $_GET['search'] != "") {
    $search = $_GET['search'];
    $_GET['mode'] = 2;
}

$v_rss = array();
$v_rssa = array();

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
        } else if (isset($search)) {
            $id = 0;
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


