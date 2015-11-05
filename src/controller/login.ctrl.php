<?php
    // Test if login + psw = user
    // Else redirect with error

session_start();
require_once('../model/DAO.class.php');

if (isset($_POST['connect'])) {
    if (!isset($_POST['user']) || $_POST['user'] == '' || !isset($_POST['password']) || $_POST['password'] == '') {
        $message = '<div class="alert alert-warning"><strong>Impossible de récupérer vos informations correctement</strong><br>Veuillez réessayer.</div>';
    } else {
        $user = $_POST['user'];
        $password = $_POST['password'];

        $log = $dao->tryLogin($user, $password);

        if ($log) {
            $_SESSION['user'] = $user;
            $_SESSION['isAdmin'] = $dao->isAdmin($user);
            $message = '<div class="alert alert-success"><strong>Indentification réussie!</strong><br>Vous êtes maintenant connecté.</div>';
        } else {
            $message = '<div class="alert alert-warning"><strong>Informations incorrectes.</strong><br>Veuillez vérifier les informations entrées et réessayer.</div>';
        }
    }
} else if (isset($_POST['signup'])) {
    if (!isset($_POST['user']) || $_POST['user'] == '' || !isset($_POST['password']) || $_POST['password'] == '') {
        $message = '<div class="alert alert-warning"><strong>Impossible de récupérer vos informations correctement</strong><br>Veuillez réessayer.</div>';
    } else {
        $user = $_POST['user'];
        $password = $_POST['password'];

        $compteCree = $dao->creerUtilisateur($user, $password);

        $message = '<div class="alert alert-success"><strong>Compte correctement crée!</strong><br>Votre compte a été créé. Veuiller vous connecter.</div>';
    }
} else {
    $message = '<div class="alert alert-danger"><strong>Une erreur inconnue est survenue!</strong><br>Une erreur complètement inconnue est survenue. Attention!</div>';
}