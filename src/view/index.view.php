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
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="parametres.ctrl.php">Paramètres</a></li>
                            <?php
                                if ($logged && $isAdmin):
                            ?>
                                <li><a href="backoffice.ctrl.php">Backoffice</a></li>
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
                        <ul class="nav navbar-right">
                            <form class="navbar-form navbar-left" role="search" action="index.ctrl.php" method="GET">
                                <div class="form-group">
                                    <input type="text" class="form-control input-sm" placeholder="Le Monde, ..." name="search">
                                </div>
                                <button type="submit" class="btn btn-sm btn-default">Rechercher</button>
                            </form>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>

            <div id="titre">
                <h1><?= $titrePrincipal ?></h1>
            </div>
            <?php
                if ($mode == 4 && $helpMessages):
            ?>
            <div id="description" class="alert alert-dismissable alert-info">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <h2>Description du site</h2><br />Ce site liste les flux RSS qui vous intéressent.<br />
                Il a été réalisé par des étudiants de 2ème année de l'IUT Informatique de Grenoble.
            </div>
            <?php
                endif;
            ?>
        </header>
        
        <div id="contents">
            <?php
                include($includeFile);
            ?>
        </div>
        
        <?php include('footer.php') ?>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../../resources/js/bootstrap.min.js"></script>
    </body>
</html>