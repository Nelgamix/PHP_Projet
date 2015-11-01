<?php
require_once('../../kint/Kint.class.php');
require_once('../model/DAO.class.php');
include_once('session.ctrl.php');

$titrePrincipal = "Paramètres de l'application";

if ($logged) {
    foreach ($_POST as $k => $val) {
        if ($val == "S'abonner") {
            // S'abonner
            if (isset($_POST['nom']) && isset($_POST['categorie']) && $_POST['nom'] != '' && $_POST['categorie'] != '') {
                $nom = $_POST['nom'];
                $categorie = $_POST['categorie'];

                $dao->addAbonnement($user, $k, $nom, $categorie);
            }
        } else if ($val == "Se désabonner" || $val == "Supprimer") {
            // Supprimer
            $dao->removeAbonnement($user, $k);
        } else if ($val == "Changer le nom") {
            // Changer le nom
            if (isset($_POST['champPr']) && $_POST['champPr'] != '') {
                $dao->changerNomAbonnement($user, $k, $_POST['champPr']);
            }
        } else if ($val == "Changer la catégorie") {
            // Changer la catégorie
            if (isset($_POST['champPr']) && $_POST['champPr'] != '') {
                $dao->changerCategorieAbonnement($user, $k, $_POST['champPr']);
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
}

include('../view/parametres.view.php');