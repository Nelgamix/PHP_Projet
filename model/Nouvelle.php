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
    
    private $m_link;
    private $m_title;
    private $m_description;
    private $m_pubDate;
    private $m_guid;
    private $m_enclosure;
    
    function getLink(){return $this->m_link;}
    function getTitle(){return $this->m_title;}
    function getDescription(){return $this->m_description;}
    function getPubDate(){return $this->m_pubDate;}
    function getGuid(){return $this->m_guid;}
    function getEnclosure(){return $this->m_enclosure;}
    
    function update(DOMElement $item) {
        $nodeList = $item->getElementsByTagName('title');
        $this->m_title    = $nodeList->item(0)->textContent;

        $nodeList = $item->getElementsByTagName('description');
        $this->m_description  = $nodeList->item(0)->textContent;
        
        $nodeList = $item->getElementsByTagName('pubDate');
        $this->m_pubDate  = $nodeList->item(0)->textContent;
        
        $nodeList = $item->getElementsByTagName('guid');
        $this->m_guid  = $nodeList->item(0)->textContent;
        
        $nodeList = $item->getElementsByTagName('enclosure');
        $this->m_enclosure  = $nodeList->item(0)->textContent;
        
        $nodeList = $item->getElementsByTagName('link');
        $this->m_link = $nodeList->item(0)->textContent;
        
        
      }
      
    function downloadImage($imageId) {
        // On suppose que $node est un objet sur le noeud 'enclosure' d'un flux RSS
        // On tente d'accéder à l'attribut 'url'
        $node = $this->m_enclosure;
        
        if ($node != NULL) {
              // L'attribut url a été trouvé : on récupère sa valeur, c'est l'URL de l'image
              $url = $node->nodeValue;
              // On construit un nom local pour cette image : on suppose que $nomLocalImage contient un identifiant unique
              $this->m_image = 'images/'.$imageId.'.jpg';
              file_put_contents($this->m_image, file_get_contents($url));     
        }
    }
      
    /*function downloadImages(DOMElement $item, $imageId) {
        // On suppose que $node est un objet sur le noeud 'enclosure' d'un flux RSS
        // On tente d'accéder à l'attribut 'url'
        $node = $item->getElementsByTagName('enclosure');
        $node = $node->item(0)->attributes->getNamedItem('url');
        
        if ($node != NULL) {
              // L'attribut url a été trouvé : on récupère sa valeur, c'est l'URL de l'image
              $url = $node->nodeValue;
              // On construit un nom local pour cette image : on suppose que $nomLocalImage contient un identifiant unique
              $this->m_image = 'images/'.$imageId.'.jpg';
              file_put_contents($this->m_image, file_get_contents($url));     
        }
    }*/
    
}