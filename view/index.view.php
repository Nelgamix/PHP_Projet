<!DOCTYPE html>
<html>
    <head>
        <title>Flux RSS</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="../view/style.css" />
        <style>
            .peterSpan {
                color: red;
                font-style: oblique;
            }
            
            .peterSpan:hover {
                color: blue;
            }
        </style>
    </head>
    
    <body>
        <header>
            
        </header>
        
        <div>
            <h1>Flux RSS (Le Monde)</h1>
        </div>
        
        <?php
            // Affiche le titre et la description de toutes les nouvelles
            foreach($rss->getNouvelles() as $nouvelle) {
                echo('<p>');
                print("<h3>{$nouvelle->getTitle()}</h3>");
                print("<span class='peterSpan'>Date</span> : {$nouvelle->getPubDate()} <br/>");
                print("<span class='peterSpan'>Description</span> : {$nouvelle->getDescription()} <br/>");
                print("<span class='peterSpan'><a href='{$nouvelle->getLink()}'>Link vers la news</a></span>  <br/>");
                echo('</p>');
            }
        ?>
        
        <footer>
            
        </footer>
    </body>
</html>