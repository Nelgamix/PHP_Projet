<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Flux RSS</title>
        <link href="../../resources/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../resources/css/new.css" />
    </head>

    <body>
        <header>
            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.ctrl.php">RSS Listings</a>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="index.ctrl.php">Home</a></li>
                            <li><a href="parametres.ctrl.php">Paramètres</a></li>
                            <?php
                                if ($logged && $isAdmin):
                            ?>
                                <li class="active"><a href="backoffice.ctrl.php">Backoffice</a></li>
                            <?php
                                endif;
                            ?>
                        </ul>
                        <?php
                            if ($logged):
                        ?>
                            <p class="navbar-text navbar-right">Connecté en tant que <a href="parametres.ctrl.php" class="navbar-link"><?= $user ?></a></p>
                        <?php
                            endif;
                        ?>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>

            <div id="titre">
                <h1><?= $titrePrincipal ?></h1>
            </div>

            <div id="description" class="alert alert-dismissable alert-info">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <h2>Back-office</h2><br />Le back-office est un panel de gestion pour l'admin.<br />
                Il permet de gérer globalement l'application et les données qui sont opérables.
            </div>
        </header>

        <?php
            if (isset($message)):
        ?>
            <div id="result_bo" class="alert alert-dismissable <?= $alertType ?>">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?= $message ?>
            </div>
        <?php
            endif;
        ?>

        <div id="contents">
            <div id="backoffice">
                <p>Statistiques globales</p>
                <ul>
                    <li>Nombre de nouvelles au total: <?= $data['nbNouvelles'] ?></li>
                </ul>
                <p>Actions globales</p>
                <ul>
                    <li><a href="#" onclick="add()" class="btn btn-xs btn-primary">Ajout d'un flux</a></li>
                    <li><a href="backoffice.ctrl.php?action=update&id=0" class="btn btn-xs btn-primary">Mise à jour des flux</a></li>
                    <li><a href="backoffice.ctrl.php?action=clean&id=0" class="btn btn-xs btn-warning">Vidages des flux</a></li>
                    <li><a href="backoffice.ctrl.php?action=delete&id=0" class="btn btn-xs btn-danger">Suppression de tous les flux</a></li>
                </ul>
                <p>Actions sur flux distinct</p>
                <ul>
                    <?php
                        if (!empty($v_rss)) {
                            foreach ($v_rss as $rss) {
                                print("<li><strong>{$rss->getTitre()} [{$rss->getId()}]</strong> &rightarrow; [Nouvelles: {$rss->nbNouvelles}] [Màj: {$rss->getDate()}] " .
                                    "<a href='index.ctrl.php?mode=2&id={$rss->getId()}' class='btn btn-xs btn-default'>Accéder</a> " .
                                    "<a href='backoffice.ctrl.php?action=update&id={$rss->getId()}' class='btn btn-xs btn-primary'>Mettre à jour</a> " .
                                    "<a href='backoffice.ctrl.php?action=clean&id={$rss->getId()}' class='btn btn-xs btn-warning'>Vider</a> " .
                                    "<a href='backoffice.ctrl.php?action=delete&id={$rss->getId()}' class='btn btn-xs btn-danger'>Supprimer</a></li>");
                            }
                        } else {
                            print('<li>Aucun résultat à afficher ici</li>');
                        }
                    ?>
                </ul>
                <p>Actions sur utilisateurs</p>
                <ul>
                    <?php
                    if (!empty($users)) {
                        foreach ($users as $userk) {
                            print("<li><strong>{$userk->getLogin()}</strong> {$userk->adminBtn} " .
                                "<a href='backoffice.ctrl.php?action=deleteUser&user={$userk->getLogin()}' class='btn btn-xs btn-danger'>Supprimer</a></li>");
                        }
                    } else {
                        print('<li>Aucun résultat à afficher ici</li>');
                    }
                    ?>
                </ul>
            </div>
        </div>

        <footer>
            <div>
                <?php
                    /*foreach (glob("../model/images/2_*.jpg") as $image) {
                        print('Deleting ' .$image . '...<br>');
                        //unlink($image);
                    }*/
                ?>
            </div>
        </footer>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../../resources/js/bootstrap.min.js"></script>
        <script>
            function add() {
                var response = prompt("Entrez l'url du flux à ajouter", "http://www.url.com/flux");

                if (response !== "" && response != null) {
                    window.location.replace("backoffice.ctrl.php?action=add&url=" + response);
                } else {
                    return false;
                }
            }
        </script>
    </body>
</html>