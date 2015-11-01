<?php

class Abonnement {
    private $utilisateur_login;
    private $RSS_id;
    private $categorie;
    private $nom;

    function getUser() { return $this->utilisateur_login; }
    function getRSSid() { return $this->RSS_id; }
    function getCategorie() { return $this->categorie; }
    function getNom() { return $this->nom; }
}