<?php

    require_once('../model/DAO.class.php');
    require_once('../view/afficher_nouvelles.view.php');

    class NouvellesController {
        private $id;
        private $view;
        private $flux;

        function __construct($id) {
            $this->view = new Nouvelles($this);
            $this->id = $id;
            global $dao;

            $this->flux = $dao->getRSSFromId($id);

            if ($this->flux == NULL) {
                die("Cant fetch rss with id $id");
            }
        }

        function render() {
            $output = $this->view->output();

            print($output);
        }

        function getFlux() {
            return $this->flux;
        }
    }