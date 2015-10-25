<?php
require_once('Nouvelle.class.php');
require_once('DAO.class.php');

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
    function getTitre()     { return $this->titre; }
    function getUrl()       { return $this->url; }
    function getDate()      { return $this->date; }
    function getNouvelles() { return $this->nouvelles; }
    
    // Récupère un flux à partir de son URL
    function update() {
        global $dao;

        // Cree un objet pour accueillir le contenu du RSS : un document XML
        $doc = new DOMDocument;

        //Telecharge le fichier XML dans $rss
        $doc->load($this->url);
        
        // Recupère la liste (DOMNodeList) de tous les elements de l'arbre 'title'
        $nodeTitle =    $doc->getElementsByTagName('title');
        $nodePubDate =  $doc->getElementsByTagName('pubDate');
        
        $this->titre =  $nodeTitle->item(0)->textContent;
        $this->date =   $nodePubDate->item(0)->textContent;
        
        // Mise à jour du RSS dans la BDD
        $id = $dao->updateRSS($this)['id'];
        
        // Recupère tous les items du flux RSS
        foreach ($doc->getElementsByTagName('item') as $node) {
            $nouvelle = new Nouvelle();

            // Met à jour la nouvelle avec l'information téléchargée
            $nouvelle->update($node);

            // Télécharge l'image
            $nouvelle->downloadImage($node);
            
            $dao->createNouvelle($nouvelle, $id);
        }
        
        $this->nouvelles = $dao->getNouvellesFromRSS($this->url);
    }
}

