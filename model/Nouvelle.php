<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Nouvelle
 *
 * @author ouastans
 */
class Nouvelle {
    //put your code here
    
    private $link;
    private $title;
    private $description;
    private $pubDate;
    private $guid;
    private $enclosure;
    
    function getLink(){return $this->link;}
    function getTitle(){return $this->title;}
    function getDescription(){return $this->description;}
    function getPubDate(){return $this->pubDate;}
    function getGuid(){return $this->guid;}
    function getEnclosure(){return $this->enclosure;}
    
    
    
    function update(DOMElement $item) {

        $nodeList = $item->getElementsByTagName('title');
        $this->title    = $nodeList->item(0)->textContent;

        $nodeList = $item->getElementsByTagName('description');
        $this->description  = $nodeList->item(0)->textContent;
        
        $nodeList = $item->getElementsByTagName('pubDate');
        $this->pubDate  = $nodeList->item(0)->textContent;
        
        //$nodeList = $item->getElementsByTagName('guid');
        //$this->guid  = $nodeList->item(0)->textContents;
        
        $nodeList = $item->getElementsByTagName('enclosure');
        $this->enclosure  = $nodeList->item(0)->textContent;
        
      }
      
      function downloadImage(DOMElement $item, $imageId){
      
        // On suppose que $node est un objet sur le noeud 'enclosure' d'un flux RSS
        // On tente d'accéder à l'attribut 'url'
        $node = $item->getElementsByTagName('enclosure');
        $node = $node->item(0)->attributes->getNamedItem('url');
        if ($node != NULL) {
              // L'attribut url a été trouvé : on récupère sa valeur, c'est l'URL de l'image
              $url = $node->nodeValue;
              // On construit un nom local pour cette image : on suppose que $nomLocalImage contient un identifiant unique
              $this->image = 'images/'.$imageId.'.jpg';
              file_put_contents($this->image, file_get_contents($url));     
        }
      }
      
      function downloadImages(DOMElement $item, $imageId){
      
        // On suppose que $node est un objet sur le noeud 'enclosure' d'un flux RSS
        // On tente d'accéder à l'attribut 'url'
        $node = $item->getElementsByTagName('enclosure');
        $node = $node->item(0)->attributes->getNamedItem('url');
        if ($node != NULL) {
              // L'attribut url a été trouvé : on récupère sa valeur, c'est l'URL de l'image
              $url = $node->nodeValue;
              // On construit un nom local pour cette image : on suppose que $nomLocalImage contient un identifiant unique
              $this->image = 'images/'.$imageId.'.jpg';
              file_put_contents($this->image, file_get_contents($url));     
        }
      }
}