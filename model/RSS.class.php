<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RSS
 *
 * @author ouastans
 */
class RSS {
    private $titre; // Titre du flux
    private $url;   // Chemin URL pour télécharger un nouvel état du flux
    private $date;  // Date du dernier téléchargement du flux
    private $nouvelles; // Liste des nouvelles du flux

    // Contructeur
    function __construct($url) {
      $this->url = $url;
    }

    // Fonctions getter
    function getTitre() {return $this->titre;}
    function getUrl() {return $this->url;}
    function getDate() {return $this->date;}
    function getNouvelles() {return $this->nouvelles;}
    
    // Récupère un flux à partir de son URL
    function update() {
        // Cree un objet pour accueillir le contenu du RSS : un document XML
        $doc = new DOMDocument;

        //Telecharge le fichier XML dans $rss
        $doc->load($this->url);

        // Recupère la liste (DOMNodeList) de tous les elements de l'arbre 'title'
        $nodeList = $doc->getElementsByTagName('title');

        // Met à jour les infos de l'objet
        $this->titre = $nodeList->item(0)->textContent;
        $this->url = $nodeList->item(0)->textContent;
        $this->date = $nodeList->item(0)->textContent;
        $this->nouvelles = $nodeList->item(0)->textContent;
    }
    
    
    
    
}

