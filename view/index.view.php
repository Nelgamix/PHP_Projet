<!DOCTYPE html>
<html>
    <head>
        <title>Flux RSS</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="../view/style.css" />
        <style>
            #logbar {
                text-align: right;
                height: 50px;
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
                width: 80%;
                margin: auto;
            }
            
            #contents {
                padding: 0px 10px;
                margin-top: -1px;
                border: 1px solid black;
                background-color: blanchedalmond;
            }
            
            table {
                width: 100%;
                margin: auto;
                border-spacing: 30px;
            }
            
            table tr td {
                width: 50%;
                margin: 50px;
                vertical-align: top;
                border: 1px solid black;
                background-color: #c1d4df;
                padding: 10px;
            }
            
            .nouvelle .titre {
                font-weight: bold;
                display: inline-block;
                width: 58%;
                text-indent: 10px;
                /*text-align: justify;
                -moz-text-align-last: justify;
                text-align-last: justify;*/
            }
            
            .nouvelle .date {
                font-style: italic;
                color: goldenrod;
                font-size: smaller;
                display: inline-block;
                width: 32%;
            }
            
            .nouvelle .link a {
                text-decoration: none;
                color: cadetblue;
            }
            
            .nouvelle .link a:hover {
                text-decoration: underline;
                color: red;
            }
            
            h1 {
                text-align: center;
            }
            
            .nouvelle {
                margin: 0;
                padding: 2px;
            }
        </style>
    </head>
    
    <body>
        <header>
            <div id="titre">
                <h1>&LT;TITRE></h1>
            </div>
            <div id="logbar">
                &lt;Log In>
            </div>
            <div id="description">
                &lt;Description of the site>
            </div>
            <div id="parametres">
                &lt;Paramètres>
            </div>
        </header>
        
        <div id="contents">
            <table>
                <?php
                    foreach($v_rss as $rss) {
                        $j = 1;
                        
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
                        
                        $i++;
                    }
                ?>
            
            <!--<?php foreach($v_rss as $rss) { ?>
            <div id="<?php echo($i++); ?>">
                <div>
                    <h1><?php echo($rss->getTitre()); ?></h1>
                </div>

                <?php
                    // Affiche le titre et la description de toutes les nouvelles
                    foreach($rss->getNouvelles() as $nouvelle) {
                        echo('<div class="item">');
                        print("<img width='300' height='200' src='../controler/{$nouvelle->getImageLocale()}' alt='Image nouvelle'/>");
                        print('<div class="description_nouvelle">');
                        print("<h3>{$nouvelle->getTitre()}</h3>");
                        print("<span class='peterSpan'>Date</span> : {$nouvelle->getDate()} <br/>");
                        print("<span class='peterSpan'>Description</span> : {$nouvelle->getDescription()} <br/>");
                        print("<span class='peterSpan'><a href='{$nouvelle->getUrl()}'>Link vers la news</a></span>  <br/>");
                        print('</div>');
                        echo('</div>' . "\n");
                    }
                ?>
            </div> <?php } ?>-->
            </table>
        </div>
        
        <footer>
            
        </footer>
            
    </body>
</html>