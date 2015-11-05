<div id="images_display">
    <?php
        if (!empty($nouvellesImg)) {
            foreach ($nouvellesImg as $k => $img) {
                print("<a href='index.ctrl.php?mode=1&id=$k'><img src='{$img['url']}' class='img-thumbnail' width='400' height='250' title=\"{$img['titre']}\"/></a>");
            }
        } else {
            print('<h3 style="text-align: center">Aucune image n\'est disponible pour ce flux.</h3>');
        }
    ?>
</div>
