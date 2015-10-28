<?php
    class Flux
    {
        private $controller;

        public function __construct($controller) {
            $this->controller = $controller;
        }

        public function output() {
            $urls = $this->controller->getUrls();

            $toReturn = '<div>';
            foreach ($urls as $url) {
                $toReturn .= '<a href="' . $url . '">' . $url . "</a><br />\n";
            }
            $toReturn .= '</div>';

            return $toReturn;
        }
    }