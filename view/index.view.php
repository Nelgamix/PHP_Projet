<!DOCTYPE html>
<html>
    <head>
        <title>Flux RSS</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="../view/style.css" />
        <style>
            #logbar {
                text-align: right;
                height: 40px;
                background-color: #93a1a1;
            }
            
            #description {
                height: 100px;
                background-color: #2aa198;
            }
            
            #parametres {
                height: 75px;
                background-color: #0092db;
            }
            
            body {
                width: 70%;
                margin: auto;
            }
            
            form {
                margin: 6px;
                padding: 6px;
            }
            
            #contents {
                padding: 0px 10px;
                margin-top: -1px;
                border: 1px solid black;
                background-color: blanchedalmond;
            }
            
            h1 {
                text-align: center;
            }
            
            a {
                color: black;
                text-decoration: none;
            }
            
            a h2 {
                margin-top: 10px;
                margin-bottom: 5px;
                text-decoration: underline;
            }
            
            h2:hover {
                color: red;
            }
            
            h2 {
                color: black;
            }
            
            .rss {
                margin: 20px 30px;
                padding: 0 10px;
                border: 1px solid black;
                background-color: appworkspace;
            }
            
            .nouvelle {
                overflow: auto;
                margin-bottom: 10px;
                padding-right: 15px;
                border: 1px solid black;
                background-color: #657b83;
                transition: 0.5s;
            }
            
            .nouvelle:hover {
                background-color: #ccc;
                box-shadow: 5px 5px 5px white;
                transition: 0.5s;
            }
            
            .date {
                font-style: italic;
                color: #3399ff;
            }
            
            .description {
                margin-top: 15px; 
            }
            
            img {
                float: left;
                margin-right: 20px;
                clear: both;
            }
            
            img:hover {
                -moz-box-shadow: 0 0 10px #ff0000;
                -webkit-box-shadow: 0 0 10px #ccc;
                box-shadow: 0 0 10px #ff0000;
            }
            
            .description>img {
                display: none;
            }
        </style>
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

                    print('<div class="rss">');
                    print('<a href="' . $rss->getUrl() . '" title="Aller sur le site propriétaire du RSS"'
                            . ' target="_blank"><h1>' . $rss->getTitre() . '</h1></a>');

                    foreach($rss->getNouvelles() as $nouvelle) {
                        print('<div class="nouvelle">');

                        print('<a href="' . $nouvelle->getUrl() . '" title="Lire la suite..." target="_blank">'
                                . '<img width="400" height="225" src="../controler/'
                                . $nouvelle->getImageLocale() . '" alt="image nouvelle" /></a>');
                        print('<a href="' . $nouvelle->getUrl() . '" title="Lire la suite..." target="_blank"><h2>'
                                . $nouvelle->getTitre() . '</h2></a>');
                        print('<div class="date">' . $nouvelle->getDate() . '</div>');
                        print('<div class="description">' . $nouvelle->getDescription() . '</div>');

                        print('</div>');
                    }

                    print('</div>');
                }
            ?>
        </div>
        
        <footer>
            
        </footer>
            
    </body>
</html>