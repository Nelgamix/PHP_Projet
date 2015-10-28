<?php

    require_once('../model/DAO.class.php');
    require_once('../view/afficher_nouvelle.view.php');

    class NouvelleController {
        private $nouvelle;

        function __construct(Nouvelle $nouvelle) {
            $this->nouvelle = $nouvelle;
        }
    }