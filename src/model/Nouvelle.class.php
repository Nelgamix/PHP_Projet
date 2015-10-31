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
        if (!isset($this->imageLocale)) {
            if ($this->image == "default")
                $this->imageLocale = "../model/images/default.jpg";
            else
                $this->imageLocale = "../model/images/" . $dao->getRSSIdFromNouvelle($this) . "_" . $dao->getIdNouvelle($this) . ".jpg";
        }
        return $this->imageLocale;
    }
    function getId() {
        global $dao;
        if (!isset($this->id)) {
            $this->id = $dao->getIdNouvelle($this);
        }
        return $this->id;
    }
    
    function setImageLocal($imageUrlLocal)     { $this->image = $imageUrlLocal; }
    
    function update(DOMElement $item) {
        $title =         $item->getElementsByTagName('title');
        $description =   $item->getElementsByTagName('description');
        $pubDate =       $item->getElementsByTagName('pubDate');
        $link =          $item->getElementsByTagName('link');
        $nodeEnclosure = $item->getElementsByTagName('enclosure');
        
        $this->titre  =       $title->item(0)->textContent;
        $this->description =  $description->item(0)->textContent;
        $this->date =         $pubDate->item(0)->textContent;
        $this->url =          $link->item(0)->textContent;
        if ($nodeEnclosure != NULL)
            $this->image = $nodeEnclosure->item(0)->attributes->getNamedItem('url')->nodeValue;
        else
            $this->image = "default";
    }
    
}