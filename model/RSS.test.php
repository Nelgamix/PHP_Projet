<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * 
 * Description of RSS
 *
 * @author ouastans
 */
      // Test de la classe RSS
      require_once('RSS.class.php');

      // Une instance de RSS
      $rss = new RSS('http://www.lemonde.fr/m-actu/rss_full.xml');

      // Charge le flux depuis le réseau
      $rss->update();

      // Affiche le titre
      echo $rss->getTitre()."\n";
