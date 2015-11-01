<?php
    // Test if login + psw = user
    // Else redirect with error
    // TODO finir cette page
session_start();

require_once('../model/DAO.class.php');
require_once('../../kint/Kint.class.php');

if (!isset($_POST['signup']) && !isset($_POST['connect'])) {
    die("Impossible d'indentifier votre demande");
}

if (isset($_POST['connect'])) {
    print('Trying to connect');

    if (!isset($_POST['user']) || $_POST['user'] == '' || !isset($_POST['password']) || $_POST['password'] == '') {
        die("Impossible de récupérer les bons paramètres\n");
    }

    $user = $_POST['user'];
    $password = $_POST['password'];

    $log = $dao->tryLogin($user, $password);

    if ($log) {
        $_SESSION['user'] = $user;
    }

    if (isset($_SESSION['user'])) {
        $message = "with user {$_SESSION['user']}";
    } else {
        $message = '.';
    }

    session_commit();

    //die("Connecté: $log $message" . " <a href='index.ctrl.php'>get back</a>");
} else if (isset($_POST['signup'])) {
    print('Trying to signup');

    if (!isset($_POST['user']) || $_POST['user'] == '' || !isset($_POST['password']) || $_POST['password'] == '') {
        die("Impossible de récupérer les bons paramètres\n");
    }

    $user = $_POST['user'];
    $password = $_POST['password'];

    $compteCree = $dao->creerUtilisateur($user, $password);

    session_commit();

    //die("Compte crée avec user $user" . " <a href='index.ctrl.php'>get back</a>");
}

header('Location: parametres.ctrl.php');
die('Sometttthhhhingssss went wrong');