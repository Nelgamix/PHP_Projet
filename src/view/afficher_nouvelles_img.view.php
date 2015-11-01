<div id="images_display">
    <?php
        foreach ($nouvellesImg as $k => $img) {
            print("<a href='index.ctrl.php?mode=1&id=$k'><img src='{$img['url']}' class='img-thumbnail' width='400' height='250' title=\"{$img['titre']}\"/></a>");
        }
    ?>
</div>
