<?php
require_once('../model/DAO.class.php');
require_once('../../kint/Kint.class.php');

$titrePrincipal = "Back-office";

if (isset($_GET['action'])) {
    if ($_GET['action'] == "update" && isset($_GET['id'])) {
        // update
        $id = $_GET['id'];

        if ($id == 0) {
            // update all
            $v_rss = $dao->constructAllRSS();
            foreach ($v_rss as $rss) {
                $rss->update();
            }
            $message = "<strong>Mise à jour réussie!</strong> " .
                "Tous les RSS ont bien été mis à jour.";
            $alertType = "alert-success";
        } else {
            // update only one
            $rss = $dao->constructRSS($id);
            if (isset($rss)) {
                $rss->update();
                $message = "<strong>Mise à jour réussie!</strong> " .
                    "Le RSS avec l'id $id a bien été mis à jour.";
                $alertType = "alert-success";
            } else {
                $message = "<strong>Mise à jour ratée.</strong> " .
                    "Le RSS avec l'id $id n'a pas pu être mis à jour. (vérifiez qu'il existe bien)";
                $alertType = "alert-warning";
            }
        }
    } else if ($_GET['action'] == "clean" && isset($_GET['id'])) {
        // clean
        $id = $_GET['id'];

        if ($id == 0) {
            // clean all
            $dao->cleanAllRSS();
            $message = "<strong>Vidage réussi.</strong> " .
                "Tous les RSS ont bien été vidés.";
            $alertType = "alert-success";
        } else {
            // clean only one
            if ($dao->cleanRSS($id)) {
                $message = "<strong>Vidage réussi.</strong> " .
                    "Le RSS avec l'id $id a bien été vidé.";
                $alertType = "alert-success";
            } else {
                $message = "<strong>Vidage réussi.</strong> " .
                    "Le RSS avec l'id $id n'a pas pu être vidé.";
                $alertType = "alert-warning";
            }
        }
    } else if ($_GET['action'] == "delete" && isset($_GET['id'])) {
        // delete
        $id = $_GET['id'];

        if ($id == 0) {
            // delete all
            $dao->deleteAllRSS();
            $message = "<strong>Suppression réussie!</strong> " .
                "Tous les RSS ont bien été supprimés, ajoutez-en d'autres si besoin.";
            $alertType = "alert-success";
        } else {
            // delete only one
            if ($dao->deleteRSS($id)) {
                $message = "<strong>Suppression réussie!</strong> " .
                    "Le RSS avec l'id $id a bien été supprimé.";
                $alertType = "alert-success";
            } else {
                $message = "<strong>Suppression ratée.</strong> " .
                    "Le RSS avec l'id $id n'a pas pu être supprimé. Vérifiez qu'il existe encore.";
                $alertType = "alert-warning";
            }
        }

        $message = "<strong>Suppression réussie!</strong> " .
            "Le RSS avec l'id $id a bien été supprimé.";
        $alertType = "alert-success";
    } else if ($_GET['action'] == "add" && isset($_GET['url'])) {
        // add
        $url = $_GET['url'];

        if ($dao->createRSS($url)) {
            $message = "<strong>Le RSS a correctement été créé.</strong> " .
                "Le RSS ($url) a bien été créé, mettez-le à jour pour obtenir ses nouvelles.";
            $alertType = "alert-success";
        } else {
            $message = "<strong>Le RSS n'a pas correctement été créé.</strong> " .
                "Le RSS ($url) n'a pas été créé, vérifiez si il n'existe pas déjà, et si l'url est correcte.";
            $alertType = "alert-warning";
        }
    } else {
        $message = "<strong>Impossible de récupérer vos paramètres.</strong> " .
            "Vos paramètres n'ont pas été compris (action {$_GET['action']}). Veuillez les vérifier.";
        $alertType = "alert-danger";
    }
}

$v_rss = $dao->constructAllRSS();

$data['nbNouvelles'] = 0;

foreach ($v_rss as $rss) {
    // count nouvelles
    $rss->nbNouvelles = count($rss->getNouvelles());
    $data['nbNouvelles'] += $rss->nbNouvelles;
}

include('../view/backoffice.view.php');