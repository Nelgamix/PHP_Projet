<?php

require_once('../model/DAO.class.php');

$nouvellesImg = $dao->getNouvellesTitreImg($id);

if (!isset($nouvellesImg) || empty($nouvellesImg)) {
    die('Couldnt get images of nouvelles from id ' . $id);
}

include('../view/afficher_nouvelles_img.view.php');