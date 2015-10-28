<?php
    class Nouvelles
    {
        private $controller;

        function __construct($controller) {
            $this->controller = $controller;
        }

        function output() {
            $toReturn = '<div>';

            foreach ($this->controller->getFlux()->getNouvelles() as $flux) {
                $toReturn .= '<h3>' . $flux->getTitre() . '</h3>';
            }
            $toReturn .= '</div>';

            return $toReturn;
        }
    }
