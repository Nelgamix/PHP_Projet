<?php
session_start();

// Base var
if (!isset($_SESSION['helpMessages'])) {
    $_SESSION['helpMessages'] = true;
}

if (!isset($_SESSION['showFluxGeneraux'])) {
    $_SESSION['showFluxGeneraux'] = true;
}

// Test and set values in session
if (isset($_POST['valider'])) {
    if (isset($_POST['helpMessages'])) {
        $_SESSION['helpMessages'] = true;
    } else {
        $_SESSION['helpMessages'] = false;
    }

    if (isset($_POST['showFluxGeneraux'])) {
        $_SESSION['showFluxGeneraux'] = true;
    } else {
        $_SESSION['showFluxGeneraux'] = false;
    }
}



// Get and set var to others scripts
if (isset($_SESSION['user'])) {
    $logged = true;
    $user = $_SESSION['user'];
    if (isset($_GET['disconnect']) && $_GET['disconnect'] == "true") {
        if (session_destroy()) $logged = false;
    }
} else {
    $logged = false;
}

if ($_SESSION['helpMessages'] == true) {
    $helpMessages = 'checked="checked"';
} else {
    $helpMessages = '';
}

if ($_SESSION['showFluxGeneraux'] == true) {
    $showFluxGeneraux = 'checked="checked"';
} else {
    $showFluxGeneraux = '';
}



// Commit and close session
session_commit();
