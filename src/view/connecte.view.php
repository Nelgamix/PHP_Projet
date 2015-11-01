<fieldset>
    <legend>Relatif au compte</legend>
    <div>
        <p>
            Connecté avec login <?= $user ?> <a href="parametres.ctrl.php?disconnect=true">Se déconnecter</a>
        </p>
        <p>
            Actions globales sur le compte
            <ul>
                <li>Ajouter un abonnement</li>
                <li>Supprimer tous les abonnements</li>
                <li>...</li>
            </ul>
        </p>
        <p>
            Actions sur abonnements
            <ul>
                <li>Catégorie - Nom (Abonnement) [Changer le nom] [Changer la catégorie] [Supprimer]</li>
                <?php
                    if (!empty($userAbo)) {
                        foreach ($userAbo as $abo) {
                            print("<li>{$abo->getCategorie()} - {$abo->getNom()} ({$abo->getRSSid()}) [Changer le nom] [Changer la catégorie] [Supprimer]</li>");
                        }
                    } else {
                        print("<li>Aucun abonnement.</li>");
                    }
                ?>
            </ul>
        </p>
    </div>
</fieldset>