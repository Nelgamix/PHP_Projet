<?php //Ecrire le controleur controler/afficher_flux.ctrl.php qui affiche la liste des URL des flux. Produire la vue correspondante.

$v_rss = $dao->constructAllRSS();
if ($logged) $v_rssa = $dao->getAllRSSof($user);

include('../view/afficher_flux.view.php');