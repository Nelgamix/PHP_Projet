<?php
$content = false;
foreach ($v_rss as $rss) {
    if (!empty($rss->getNouvelles())):
?>
<div id="nouvelles_display">
    <h3><?= $rss->getTitre() ?> (<a href="<?= $rss->getUrl() ?>" title="Accéder au flux">lien flux</a>)</h3>
    <?php
        $i = 0;
        foreach ($rss->getNouvelles() as $nouvelle) {
            print('<p><a href="index.ctrl.php?mode=1&id=' . $nouvelle->getId() . '">' . $nouvelle->getTitre() . '</a>' .
                ' - [' . $nouvelle->getDate() . ']</p>');
            $content = true;
            if (++$i >= $resultByFlux) break;
        }
    ?>
</div>
<?php endif; }
    if (!$content) {
        print('<div><h2 style="text-align: center; padding-top: 200px">Aucune nouvelle trouvée.</h2></div>');
    }
?>