<?php
    require_once('../model/DAO.class.php');
    require_once('../model/RSS.class.php');
    require_once('../kint/Kint.class.php');

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
    
    $i = 0;
    
    define('MAX_CHARACTERS_TITRE', 52);
    
    include("../view/index.view.php");
