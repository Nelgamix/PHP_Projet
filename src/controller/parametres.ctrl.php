<?php
require_once('../model/DAO.class.php');

$titrePrincipal = "Paramètres de l'application";

if (isset($_POST['signup']) || isset($_POST['connect'])) {
    include_once('login.ctrl.php');
}

include_once('session.ctrl.php');

if ($logged) {
    foreach ($_POST as $k => $val) {
        if ($val == "S'abonner") {
            // S'abonner
            if (isset($_POST['nom']) && isset($_POST['categorie'])) {
                $nom = $_POST['nom'];
                $categorie = $_POST['categorie'];

                if ($dao->addAbonnement($user, $k, $nom, $categorie))
                    $message = '<div class="alert alert-success">Ajout terminé.</div>';
                else
                    $message = '<div class="alert alert-warning">Ajout raté.</div>';
            }
        } else if ($val == "Se désabonner" || $val == "Supprimer") {
            // Supprimer
            if ($dao->removeAbonnement($user, $k))
                $message = '<div class="alert alert-success">Suppression terminé.</div>';
            else
                $message = '<div class="alert alert-warning">Suppression ratée.</div>';
        } else if ($val == "Changer le nom") {
            // Changer le nom
            if (isset($_POST['champPr']) && $_POST['champPr'] != '') {
                if ($dao->changerNomAbonnement($user, $k, $_POST['champPr']))
                    $message = '<div class="alert alert-success">Changement de nom terminé.</div>';
                else
                    $message = '<div class="alert alert-warning">Changement de nom raté.</div>';
            }
        } else if ($val == "Changer la catégorie") {
            // Changer la catégorie
            if (isset($_POST['champPr']) && $_POST['champPr'] != '') {
                if ($dao->changerCategorieAbonnement($user, $k, $_POST['champPr']))
                    $message = '<div class="alert alert-success">Changement de catégorie terminé.</div>';
                else
                    $message = '<div class="alert alert-warning">Changement de catégorie raté.</div>';
            }
        }
    }

    $userAbo = $dao->getAllAbonnements($user);
    $v_rss = $dao->constructAllRSS();

    foreach ($userAbo as $abo) {
        // On récupère le titre du rss, et on le met dans abo
        $abo->rssTitre = $v_rss[$abo->getRSSid()]->getTitre();
        // On set les boutons des rss associés aux abonnements
        $v_rss[$abo->getRSSid()]->userBtn = "<input type='submit' name='{$abo->getRSSid()}' class='btn btn-xs btn-primary' value='Se désabonner' />";
    }

    foreach ($v_rss as $rss) {
        // On set tous les autres pour permettre l'abonnement
        if (!isset($rss->userBtn)) {
            $rss->userBtn = "<input type='submit' name='{$rss->getId()}' class='btn btn-xs btn-warning' value=\"S'abonner\" />";
        }
    }

    if (isset($_GET['deleteAll']) && $_GET['deleteAll'] == "true") {
        if ($dao->removeAllSubscriptions($user))
            $message = '<div class="alert alert-success">Suppression globale terminée.</div>';
        else
            $message = '<div class="alert alert-warning">Suppression globale ratée.</div>';
    }
}

include('../view/parametres.view.php');