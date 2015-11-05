<?php

class Abonnement {
    private $utilisateur_login;
    private $RSS_id;
    private $categorie;
    private $nom;

    function getUser() { return $this->utilisateur_login; }
    function getRSSid() { return $this->RSS_id; }
    function getCategorie() { if (isset($this->categorie)) return $this->categorie; else return 'Pas de categorie'; }
    function getNom() { if (isset($this->nom)) return $this->nom; else return 'Pas de nom'; }
}