<!DOCTYPE html>
<html>
    <head>
        <title>Flux RSS</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="../view/style.css" />
        <style>
            body {
                margin-top: 0px;
            }
            
            .contents {
                width: 75%;
                margin: auto;
                padding: 0px 10px;
                margin-top: -1px;
                border: 1px solid black;
                background-color: blanchedalmond;
            }
            
            h1 {
                text-align: center;
            }
            
            h3 {
                margin-top: 2px;
            }
            
            div.item {
                overflow: auto;
                margin: 22px;
                border: black 1px solid;
                padding: 10px;
                background-color: lightblue;
                transition: 1s;
            }
            
            div.item:hover {
                background-color: lightgrey;
                transition: 1s;
            }
            
            .description_nouvelle { }
            
            img {
                float: left;
                margin-right: 20px;
            }
            
            .peterSpan {
                color: red;
                font-style: oblique;
                font-weight: bold;
                transition: 1s;
            }
            
            .peterSpan:hover {
                color: blue;
                transition: 1s;
            }
        </style>
    </head>
    
    <body>
        <header>
            
        </header>
        
        <div class="contents">
            <?php foreach($v_rss as $rss) { ?>
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
            </div> <?php } ?>
        </div>
        
        <footer>
            
        </footer>
            
    </body>
</html>