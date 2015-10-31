<div id="images_display">
    <?php
        foreach ($nouvellesImg as $k => $img) {
            print("<a href='index.ctrl.php?mode=1&id=$k'><img src='$img' width='400' height='225' /></a>");
        }
    ?>
</div>
