<!DOCTYPE html>
<html>
    <head>
        <title>Flux RSS</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="../../resources/css/personnalise.css" />
    </head>
    
    <body>
        <header>
            <div id="titre">
                <h1>Projet M3104 - Programmation sur serveur web</h1>
            </div>
            <div id="logbar">
                <form action="../controller/login.ctrl.php">
                    Nom: <input name="pseudo" type="text" />
                    Mot de passe: <input name="password" type="password" />
                    <input type="submit" name="submit" value="Envoyer" />
                </form>
            </div>
            <div id="description">
                &lt;Description of the site><br />Who are we?<br />Students.
            </div>
            <div id="parametres">
                &lt;Paramètres>
            </div>
        </header>
        
        <div id="contents">
            <?php
                foreach($v_rss as $rss) {
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
                }
            ?>
        </div>
        
        <footer>
            
        </footer>
            
    </body>
</html>