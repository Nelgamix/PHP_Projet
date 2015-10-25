<?php
    /*

    // Une instance de RSS
    $rss = new RSS('http://www.lemonde.fr/m-actu/rss_full.xml');

    // Charge le flux depuis le réseau
    $rss->update();

    include("../view/index.view.php");*/
    
    // Test de la classe DAO
    require_once('../model/DAO.class.php');
    require_once('../model/RSS.class.php');
    require_once('../kint/Kint.class.php');

    // Test si l'URL existe dans la BD
    $url = 'http://www.lemonde.fr/m-actu/rss_full.xml';

    $rss = $dao->readRSSfromURL($url);
    if ($rss == NULL) {
        echo $url." n'est pas connu\n";
        echo "On l'ajoute ... \n";
        $rss = $dao->createRSS($url);
    }

    // Mise à jour du flux
    $rss->update();
    
    include("../view/index.view.php");
