<?php

require_once('../model/DAO.class.php');

$nouvellesImg = $dao->getNouvellesTitreImg($id);

include('../view/afficher_nouvelles_img.view.php');