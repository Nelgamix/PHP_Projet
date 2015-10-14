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
        $this->titre    = $nodeList->item(0)->textContent;

        $nodeList = $item->getElementsByTagName('pubDate');
        $this->date  = $nodeList->item(0)->textContent;
        
      }
    
    
}
