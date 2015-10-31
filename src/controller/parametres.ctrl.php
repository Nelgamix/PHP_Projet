<?php
session_start();

require_once('../../kint/Kint.class.php');

$content = "Paramètres...";
$titrePrincipal = "Paramètres de l'application";

if (isset($_SESSION['user'])) {
    $logged = true;
    $user = $_SESSION['user'];
    if (isset($_GET['disconnect']) && $_GET['disconnect'] == "true") {
        if (session_destroy()) $logged = false;
    }
} else {
    $logged = false;
}

include('../view/parametres.view.php');