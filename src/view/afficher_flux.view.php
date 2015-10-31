<div id="flux_display">
    <h2>Flux disponibles</h2>
    <?php
        foreach ($v_rss as $rss) {
            print('<ul class="alert alert-success"><h3><a href="index.ctrl.php?mode=2&id=' . $rss->getId() . '" title="' . $rss->getTitre() . '">' . $rss->getTitre() . '</a></h3>');
            print('<a class="btn btn-xs btn-primary" href="index.ctrl.php?mode=3&id=' . $rss->getId() . '" title="Visualiser les images des nouvelles">Images</a>');
            print('&nbsp-&nbsp;<a class="btn btn-xs btn-info" href="' . $rss->getUrl() . '" title="Accéder au flux directement" target="_blank">Flux</a>');
            print('</ul>');
        }
    ?>
</div>