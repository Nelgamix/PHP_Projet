<?php

class Utilisateur {
    private $login;
    private $mp;
    private $isAdmin;

    function getLogin() { return $this->login; }
    function getMp() { return $this->mp; }
    function isAdmin() {
        if ($this->isAdmin == "true") {
            return true;
        } else {
            return false;
        }
    }
}