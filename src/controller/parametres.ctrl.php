<?php
require_once('../../kint/Kint.class.php');
require_once('../model/DAO.class.php');
include_once('session.ctrl.php');

$titrePrincipal = "Paramètres de l'application";

if ($logged) $userAbo = $dao->getAllAbonnements($user);

include('../view/parametres.view.php');