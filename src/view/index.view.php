<!DOCTYPE html>
<html>
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
                            <li><a href="#parameters">Paramètres</a></li>
                            <li><a href="#about">A propos</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>

            <div id="titre">
                <h1>Projet M3104 - Programmation sur serveur web</h1>
            </div>

            <!--<div id="logbar" class="alert">
                <form action="../controller/login.ctrl.php">
                    Login&nbsp;&nbsp;&nbsp;&nbsp;
                    Nom: <input name="pseudo" type="text" />
                    Mot de passe: <input name="password" type="password" />
                    <input type="submit" name="submit" value="Envoyer" />
                </form>
            </div>-->
            <?php
                if ($mode == 4):
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
                /*$j = 1;

                if ($i % 2 == 0) {
                    print('<tr>');
                }

                print('<td><div>');

                print("<h2>{$rss->getTitre()}</h2>");

                foreach($rss->getNouvelles() as $nouvelle) {
                    $titreNouvelle = trim($nouvelle->getTitre());
                    $descriptionNouvelle = trim($nouvelle->getDescription());
                    $dateNouvelle = trim($nouvelle->getDate());
                    $linkNouvelle = $nouvelle->getUrl();

                    // A BOUGER DANS LE CONTROLER
                    if (strlen(utf8_decode($titreNouvelle)) > MAX_CHARACTERS_TITRE) {
                        $titreNouvelle = mb_substr($titreNouvelle, 0, MAX_CHARACTERS_TITRE, 'UTF-8');
                        $newChar = preg_split('//u', $titreNouvelle, -1, PREG_SPLIT_NO_EMPTY);
                        for ($c = 2; $c != -1; $c--) {
                            $newChar[MAX_CHARACTERS_TITRE - 1 - $c] = '.';
                        }
                        $titreNouvelle = implode('', $newChar);
                    }

                    print('<div class="nouvelle">');
                    print('<span class="titre" title="'. $descriptionNouvelle .'">' . $titreNouvelle .
                            '</span> - <span class="date">' . $dateNouvelle .
                            '</span><span class="link"><a href="' . $linkNouvelle .
                            '">Lire...</a></span>');
                    print("</div>\n");
                    if ($j++ > 19) {
                        break;
                    }
                }

                print('</div></td>');

                if ($i % 2 == 1) {
                    print('</tr>');
                }

                $i++;*/

                /*print('<div class="rss">');
                print('<a href="' . $rss->getUrl() . '" title="Aller sur le site propriétaire du RSS"'
                        . ' target="_blank"><h1>' . $rss->getTitre() . '</h1></a>');

                foreach($rss->getNouvelles() as $nouvelle) {
                    print('<div class="nouvelle">');

                    print('<a href="' . $nouvelle->getUrl() . '" title="Lire la suite..." target="_blank">'
                            . '<img width="400" height="225" src="../controller/'
                            . $nouvelle->getImageLocale() . '" alt="image nouvelle" /></a>');
                    print('<a href="' . $nouvelle->getUrl() . '" title="Lire la suite..." target="_blank"><h2>'
                            . $nouvelle->getTitre() . '</h2></a>');
                    print('<div class="date">' . $nouvelle->getDate() . '</div>');
                    print('<div class="description">' . $nouvelle->getDescription() . '</div>');

                    print('</div>');
                }

                print('</div>');*/
            ?>
        </div>
        
        <footer>
            
        </footer>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="../../resources/js/bootstrap.min.js"></script>
    </body>
</html>