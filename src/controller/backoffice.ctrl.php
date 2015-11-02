<?php
require_once('../model/DAO.class.php');
require_once('../../kint/Kint.class.php');
require_once('session.ctrl.php');

if ($_SESSION['isAdmin'] != true)
    die('Accès interdit.');

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
    } else if ($_GET['action'] == "deleteUser" || $_GET['action'] == "deleteAdmin" || $_GET['action'] == "addAdmin") {
        if (isset($_GET['user']) && $_GET['user'] != "") {
            $userk = $_GET['user'];
            if ($_GET['action'] == "deleteUser") {
                if ($dao->supprimerUtilisateur($userk)) {
                    $message = "<strong>L'utilisateur a été supprimé.</strong> " .
                        "L'utilisateur $userk a bien été supprimé de la base de données.";
                    $alertType = "alert-success";
                } else {
                    $message = "<strong>L'utilisateur n'a pas été supprimé.</strong> " .
                        "L'utilisateur $userk n'a pas été supprimé de la base de données.";
                    $alertType = "alert-warning";
                }
            } else if ($_GET['action'] == "deleteAdmin") {
                if ($dao->supprimerAdmin($userk)) {
                    $message = "<strong>L'utilisateur a bien été supprimé des admins.</strong> " .
                        "L'utilisateur $userk a bien été supprimé des admins.";
                    $alertType = "alert-success";
                } else {
                    $message = "<strong>L'utilisateur n'a pas été supprimé des admins.</strong> " .
                        "L'utilisateur $userk n'a pas été supprimé des admins. Vérifiez qu'il n'était pas déjà membre normal.";
                    $alertType = "alert-warning";
                }
            } else if ($_GET['action'] == "addAdmin") {
                if ($dao->promouvoirAdmin($userk)) {
                    $message = "<strong>L'utilisateur a été promu admin.</strong> " .
                        "L'utilisateur $userk a bien été promu admin sur le site.";
                    $alertType = "alert-success";
                } else {
                    $message = "<strong>L'utilisateur n'a pas été promu.</strong> " .
                        "L'utilisateur $userk n'a pas été promu admin. Vérifiez qu'il n'était pas déjà admin.";
                    $alertType = "alert-warning";
                }
            }
        }
    } else {
        $message = "<strong>Impossible de récupérer vos paramètres.</strong> " .
            "Vos paramètres n'ont pas été compris (action {$_GET['action']}). Veuillez les vérifier.";
        $alertType = "alert-danger";
    }
}

$v_rss = $dao->constructAllRSS();
$users = $dao->getAllUsers();
if (isset($users) && !empty($users)) {
    foreach ($users as $k => $userk) {
        if ($k == $user) {
            unset($users[$k]);
        } else {
            if ($userk->isAdmin()) {
                $userk->adminBtn = "<a href='backoffice.ctrl.php?action=deleteAdmin&user={$userk->getLogin()}' class='btn btn-xs btn-warning' title='Supprimer de l" . "'" . "administration>Supprimer admin</a>";
            } else {
                $userk->adminBtn = "<a href='backoffice.ctrl.php?action=addAdmin&user={$userk->getLogin()}' class='btn btn-xs btn-primary' title='Mettre admin'>Promouvoir admin</a>";
            }
        }
    }
}

$data['nbNouvelles'] = 0;

foreach ($v_rss as $rss) {
    // count nouvelles
    $rss->nbNouvelles = count($rss->getNouvelles());
    $data['nbNouvelles'] += $rss->nbNouvelles;
}

include('../view/backoffice.view.php');