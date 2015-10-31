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
                            <li class="active"><a href="parametres.ctrl.php">Paramètres</a></li>
                            <li><a href="#about">A propos</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>

            <div id="titre">
                <h1><?= $titrePrincipal ?></h1>
            </div>

            <div id="description" class="alert alert-dismissable alert-info">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <h2>Paramètres</h2><br />Vous pouvez régler vos paramètres ici.<br />
                Si vous voulez avoir plus de possibilités, merci de vous enregistrer.
            </div>
        </header>

        <div id="contents">
            <?= $content ?>
            <?php
                if ($logged):
            ?>
            <div>
                Connecté avec login <?= $user ?> <a href="parametres.ctrl.php?disconnect=true">Se déconnecter</a>
            </div>
            <?php
                else:
            ?>
            <!-- FORM LOGIN -->
            <form action="login.ctrl.php" method="post">
                <table>
                    <thead>
                        <tr>
                            <th>Se connecter</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Utilisateur: </td>
                            <td><input type="text" name="user" /></td>
                        </tr>
                        <tr>
                            <td>Mot de passe: </td>
                            <td><input type="password" name="password" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" name="connect" value="Se connecter" /></td>
                        </tr>
                    </tbody>
                </table>
            </form>
            <!-- FORM NOUVEL USER -->
            <form action="login.ctrl.php" method="post">
                <table>
                    <thead>
                    <tr>
                        <th>S'inscrire</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Utilisateur: </td>
                        <td><input type="text" name="user" /></td>
                    </tr>
                    <tr>
                        <td>Mot de passe: </td>
                        <td><input type="password" name="password" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="signup" value="S'inscrire" /></td>
                    </tr>
                    </tbody>
                </table>
            </form>
            <?php
                endif
            ?>
        </div>

        <footer>

        </footer>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../../resources/js/bootstrap.min.js"></script>
    </body>
</html>