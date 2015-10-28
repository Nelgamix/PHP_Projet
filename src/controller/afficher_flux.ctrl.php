<?php

    require_once('../model/DAO.class.php');
    require_once('../view/afficher_flux.view.php');

    class FluxController {
        private $urls; // Le tableau de flux
        private $view;

        function __construct($v_rss) {
            // Construction de la vue
            $this->view = new Flux($this);

            // R�cup�ration des nouvelles
            $nouvelles = $v_rss[0]->getNouvelles();

            // Pour chaque nouvelle, on enregistre uniquement son url
            foreach ($nouvelles as $nouvelle) {
                $this->urls[] = $nouvelle->getUrl();
            }
        }

        function render() {
            // On r�cup�re la vue
            $output = $this->view->output();

            // On l'affiche
            print($output);
        }

        public function getUrls() {
            // On met � disposition de la vue les donn�es
            return $this->urls;
        }

    }
