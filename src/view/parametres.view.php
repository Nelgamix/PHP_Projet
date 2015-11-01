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
                    <?php
                    if ($logged):
                        ?>
                        <p class="navbar-text navbar-right">Connecté en tant que <a href="#" class="navbar-link"><?= $user ?></a></p>
                        <?php
                    endif;
                    ?>
                    <div id="navbar" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li><a href="index.ctrl.php">Home</a></li>
                            <li class="active"><a href="parametres.ctrl.php">Paramètres</a></li>
                            <li><a href="backoffice.ctrl.php">Backoffice (debug)</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>

            <div id="titre">
                <h1><?= $titrePrincipal ?></h1>
            </div>

            <?php
                if ($helpMessages):
            ?>
            <div id="description" class="alert alert-dismissable alert-info">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <h2>Paramètres</h2><br />Vous pouvez régler vos paramètres ici.<br />
                Si vous voulez avoir plus de possibilités, merci de vous enregistrer.
            </div>
            <?php
                endif;
            ?>
            <?php
                if (isset($message))
                    print($message);
            ?>
        </header>

        <div id="contents">
            <?php
                if ($logged) {
                    include('connecte.view.php');
                } else {
                    include('non_connecte.view.php');
                }
            ?>
            <fieldset>
                <legend>Autres</legend>
                <form action="parametres.ctrl.php" method="post">
                    <div class="col-md-3">
                        <p>
                            <input type="checkbox" name="helpMessages" <?= $helpMessages ?>/> Afficher les messages d'aide<br />
                            <input type="checkbox" name="showFluxGeneraux" <?= $showFluxGeneraux ?>/> Afficher les flux généraux à l'application<br />
                            <input type="number" name="resultByFlux" step="5" min="10" max="250" value="<?= $resultByFlux ?>" /> Nombre de résultats max par flux<br />
                        </p>
                        <p><input type="submit" value="Valider" name="valider" style="float: right" /></p>
                    </div>
                </form>
            </fieldset>
        </div>

        <footer>

        </footer>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../../resources/js/bootstrap.min.js"></script>
    </body>
</html>