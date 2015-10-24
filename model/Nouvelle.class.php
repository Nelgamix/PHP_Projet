<?php

class Nouvelle {
    private $m_link;
    private $m_title;
    private $m_description;
    private $m_pubDate;
    private $m_guid;
    private $m_enclosure;
    
    function getLink()          { return $this->m_link; }
    function getTitle()         { return $this->m_title; }
    function getDescription()   { return $this->m_description; }
    function getPubDate()       { return $this->m_pubDate; }
    function getGuid()          { return $this->m_guid; }
    function getEnclosure()     { return $this->m_enclosure; }
    
    function update(DOMElement $item) {
        $title =        $item->getElementsByTagName('title');
        $description =  $item->getElementsByTagName('description');
        $pubDate =      $item->getElementsByTagName('pubDate');
        $guid =         $item->getElementsByTagName('guid');
        $enclosure =    $item->getElementsByTagName('enclosure');
        $link =         $item->getElementsByTagName('link');
        
        $this->m_title  =       $title->item(0)->textContent;
        $this->m_description =  $description->item(0)->textContent;
        $this->m_pubDate =      $pubDate->item(0)->textContent;
        $this->m_guid =         $guid->item(0)->textContent;
        $this->m_enclosure =    $enclosure->item(0)->textContent;
        $this->m_link =         $link->item(0)->textContent;
    }
      
    function downloadImage(DOMElement $item, $imageId) {
        // On suppose que $node est un objet sur le noeud 'enclosure' d'un flux RSS
        // On tente d'accéder à l'attribut 'url'
        $nodeEnclosure = $item->getElementsByTagName('enclosure');
        $node = $nodeEnclosure->item(0)->attributes->getNamedItem('url');
        
        if ($node != NULL) {
            // L'attribut url a été trouvé : on récupère sa valeur, c'est l'URL de l'image
            $url = $node->nodeValue;
            // On construit un nom local pour cette image : on suppose que $nomLocalImage contient un identifiant unique
            $this->m_image = "images/$imageId.jpg";
            
            if (!file_exists($this->m_image)) {
                file_put_contents($this->m_image, file_get_contents($url)); 
            }
        }
    }
    
}