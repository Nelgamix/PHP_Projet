<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $titre ?></h3>
    </div>
    <div class="panel-body" id="conteneur">
        <div id="imagecontent"><img src="<?= $image ?>" width="640" height="360" /></div>
        <div class="panel panel-default" id="textcontent">
            <div class="panel-heading">
                <h3 class="panel-title">Contenu</h3>
            </div>
            <div class="panel-body">
                <?= $description ?><br /><br />
                <?= $date ?>
                <a href="<?= $url ?>" title="Accéder à l'article">Accéder à l'article</a>
            </div>
        </div>
    </div>
</div>