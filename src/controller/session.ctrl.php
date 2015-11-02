<?php
session_start();

/*
 * Pour chaque parametre,
 * 1 - mettre la valeur de base (POINT 1)
 * 2 - recup la valeur dans post (POINT 2)
 * 3 - mettre la var ou on veux, pour pouvoir la récup en dehors de la session dans les autres scripts
 */

// 1: Base var
if (!isset($_SESSION['helpMessages'])) {
    $_SESSION['helpMessages'] = true;
}

if (!isset($_SESSION['showFluxGeneraux'])) {
    $_SESSION['showFluxGeneraux'] = true;
}

if (!isset($_SESSION['resultByFlux'])) {
    $_SESSION['resultByFlux'] = 25;
}

// 2: Test and set values in session
if (isset($_POST['valider'])) {
    $_SESSION['helpMessages'] = isset($_POST['helpMessages']) ? true : false;
    $_SESSION['showFluxGeneraux'] = isset($_POST['showFluxGeneraux']) ? true : false;

    if (isset($_POST['resultByFlux']) && $_POST['resultByFlux'] >= 10 && $_POST['resultByFlux'] <= 250) {
        $_SESSION['resultByFlux'] = $_POST['resultByFlux'];
    }

    $message = '<div class="alert alert-success"><strong>Modification prise en compte avec succès!</strong></div>';
}



// 3: Get and set var to others scripts
if (isset($_SESSION['user'])) {
    $logged = true;
    $user = $_SESSION['user'];
    $isAdmin = $_SESSION['isAdmin'];
    if (isset($_GET['disconnect']) && $_GET['disconnect'] == "true") {
        if (session_destroy()) $logged = false;
    }
} else {
    $logged = false;
}

$helpMessages = $_SESSION['helpMessages'] ? 'checked="checked"' : '';
$showFluxGeneraux = $_SESSION['showFluxGeneraux'] ? 'checked="checked"' : '';
$resultByFlux = $_SESSION['resultByFlux'] ? $_SESSION['resultByFlux'] : 25;




// Commit and close session
session_commit();
