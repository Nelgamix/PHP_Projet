<!DOCTYPE html>
<html>
    <head>
        <title>Flux RSS</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="../view/style.css" />
        <style>
            body {
                width: 75%;
                margin: auto;
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
            }
            
            .description_nouvelle { }
            
            img {
                float: left;
                margin-right: 20px;
            }
            
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
                echo('<div class="item">');
                print("<img src='../controler/{$nouvelle->m_image}' alt='Image nouvelle'/>");
                print('<div class="description_nouvelle">');
                print("<h3>{$nouvelle->getTitle()}</h3>");
                print("<span class='peterSpan'>Date</span> : {$nouvelle->getPubDate()} <br/>");
                print("<span class='peterSpan'>Description</span> : {$nouvelle->getDescription()} <br/>");
                print("<span class='peterSpan'><a href='{$nouvelle->getLink()}'>Link vers la news</a></span>  <br/>");
                print('</div>');
                echo('</div>');
            }
        ?>
        
        <footer>
            
        </footer>
    </body>
</html>