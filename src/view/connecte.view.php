<fieldset>
    <legend>Relatif au compte</legend>
    <div id="connecte_content">
        <p>
            Connecté avec login <?= $user ?> <a href="parametres.ctrl.php?disconnect=true">Se déconnecter</a>
        </p>
        <div>
            <h4>Actions globales sur le compte</h4>
            <ul>
                <li><a href="parametres.ctrl.php?deleteAll=true" class="btn btn-xs btn-danger"
                       title="Supprimer tous les abonnements du compte">Supprimer tous les abonnements</a></li>
            </ul>
        </div>
        <div>
            <form action="parametres.ctrl.php" method="post">
                <h4>Abonnements disponibles</h4>
                <ul>
                    <?php
                        if (!empty($v_rss)) {
                            foreach ($v_rss as $rss) {
                                print("<li><strong>{$rss->getTitre()} [{$rss->getId()}]</strong> &rightarrow; [Màj: {$rss->getDate()}] " .
                                    "<a href='index.ctrl.php?mode=2&id={$rss->getId()}' class='btn btn-xs btn-default'>Accéder</a> " .
                                    "$rss->userBtn\n");
                            }
                        } else {
                            print("<li>Aucun flux n'est disponible.</li>");
                        }
                    ?>
                </ul>
                <div class="alert alert-warning">
                    <strong>Avant TOUT ajout</strong> (renseigner les champs suivants):<br />
                    Nom de l'ajout <input type="text" name="nom" />
                    Catégorie de l'ajout <input type="text" name="categorie" />
                </div>
            </form>
        </div>
        <div>
            <form action="parametres.ctrl.php" method="post">
                <h4>Abonnements actifs</h4>
                <ul>
                    <?php
                    if (!empty($userAbo)) {
                        foreach ($userAbo as $abo) {
                            print("<li>{$abo->getCategorie()} - {$abo->getNom()} ({$abo->rssTitre}) " .
                                "<a href='index.ctrl.php?mode=2&id={$abo->getRSSid()}' class='btn btn-xs btn-default'>Accéder</a> " .
                                "<input type='submit' class='btn btn-xs btn-success' name='{$abo->getRSSid()}' value='Changer le nom' /> " .
                                "<input type='submit' class='btn btn-xs btn-success' name='{$abo->getRSSid()}' value='Changer la catégorie' /> " .
                                "<input type='submit' class='btn btn-xs btn-warning' name='{$abo->getRSSid()}' value='Supprimer' /></li>\n");
                        }
                    } else {
                        print("<li>Aucun abonnement.</li>");
                    }
                    ?>
                </ul>
                <div class="alert alert-warning">
                    <strong>Avant TOUT changement</strong> (renseigner le champ suivant):<br />
                    Nouveau nom/catégorie <input type="text" name="champPr" />
                </div>
            </form>
        </div>
    </div>
</fieldset>