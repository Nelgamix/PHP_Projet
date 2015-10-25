<?php

require_once('DAO.class.php');

class Nouvelle {
    private $url;
    private $titre;
    private $description;
    private $date;
    private $image;
    private $imageLocale;
    
    function getUrl()            { return $this->url; }
    function getTitre()          { return $this->titre; }
    function getDescription()    { return $this->description; }
    function getDate()           { return $this->date; }
    function getImage()          { return $this->image; }
    function getImageLocale() { 
        global $dao;
        if ($this->imageLocale == NULL) {
            $this->imageLocale = "images/" . $dao->getRSSIdFromNouvelle($this) . "_" . $dao->getIdNouvelle($this) . ".jpg";
        }
        return $this->imageLocale;
    }
    
    function setImageLocal($imageUrlLocal)     { $this->image = $imageUrlLocal; }
    
    function update(DOMElement $item) {
        $title =        $item->getElementsByTagName('title');
        $description =  $item->getElementsByTagName('description');
        $pubDate =      $item->getElementsByTagName('pubDate');
        $link =         $item->getElementsByTagName('link');
        
        $this->titre  =       $title->item(0)->textContent;
        $this->description =  $description->item(0)->textContent;
        $this->date =         $pubDate->item(0)->textContent;
        $this->url =          $link->item(0)->textContent;
    }
      
    function downloadImage(DOMElement $item) {
        global $dao;
        
        // On suppose que $node est un objet sur le noeud 'enclosure' d'un flux RSS
        // On tente d'accéder à l'attribut 'url'
        $nodeEnclosure = $item->getElementsByTagName('enclosure');
        $node = $nodeEnclosure->item(0)->attributes->getNamedItem('url');
        
        if ($node != NULL) {
            // L'attribut url a été trouvé : on récupère sa valeur, c'est l'URL de l'image
            $this->image = $node->nodeValue;
            // On construit un nom local pour cette image : on suppose que $nomLocalImage contient un identifiant unique
            $dao->updateImageNouvelle($this);
        }
    }
    
}