<div id="nouvelles_display">
    <h3><?= $rss->getTitre() ?></h3>
    <?php
        foreach ($rss->getNouvelles() as $nouvelle) {
            print('<p><a href="index.ctrl.php?mode=1&id=' . $nouvelle->getId() . '">' . $nouvelle->getTitre() . '</a>' .
                ' - [' . $nouvelle->getDate() . ']</p>');
        }
    ?>
</div>