<?php
$content = false;
foreach ($v_rss as $rss) {
    if (!empty($rss->getNouvelles())):
?>
<div id="nouvelles_display">
    <h3><?= $rss->getTitre() ?></h3>
    <?php
        foreach ($rss->getNouvelles() as $nouvelle) {
            print('<p><a href="index.ctrl.php?mode=1&id=' . $nouvelle->getId() . '">' . $nouvelle->getTitre() . '</a>' .
                ' - [' . $nouvelle->getDate() . ']</p>');
            $content = true;
        }
    ?>
</div>
<?php endif; }
    if (!$content) {
        print('<div><h2 style="text-align: center; padding-top: 200px">Aucune nouvelle trouvée.</h2></div>');
    }
?>