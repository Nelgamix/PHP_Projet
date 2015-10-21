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
require_once('Nouvelle.php');

class RSS {
    private $m_titre; // Titre du flux
    private $m_url;   // Chemin URL pour télécharger un nouvel état du flux
    private $m_date;  // Date du dernier téléchargement du flux
    private $m_nouvelles; // Liste des nouvelles du flux

    // Contructeur
    function __construct($url) {
      $this->m_url = $url;
    }

    // Fonctions getter
    function getTitre() {return $this->m_titre;}
    function getUrl() {return $this->m_url;}
    function getDate() {return $this->m_date;}
    function getNouvelles() {return $this->m_nouvelles;}
    
    // Récupère un flux à partir de son URL
    function update() {
        // Cree un objet pour accueillir le contenu du RSS : un document XML
        $doc = new DOMDocument;

        //Telecharge le fichier XML dans $rss
        $doc->load($this->m_url);
        
        // Objet Nouvelle
        $nomLocalImage = 1;
        
        // Recupère tous les items du flux RSS
        foreach ($doc->getElementsByTagName('item') as $node) {
            $nouvelle = new Nouvelle();

            // Met à jour la nouvelle avec l'information téléchargée
            $nouvelle->update($node);

            // Téléchage l'image
            $nouvelle->downloadImage($nomLocalImage++);

            // Ajout dans mon tableau
            $this->m_nouvelles[] = $nouvelle;
        }
        
        // Recupère la liste (DOMNodeList) de tous les elements de l'arbre 'title'
        $nodeList = $doc->getElementsByTagName('title');
        $this->m_titre = $nodeList->item(0)->textContent;
        
        $nodeList = $doc->getElementsByTagName('pubDate');
        $this->m_date = $nodeList->item(0)->textContent;
    }
}

