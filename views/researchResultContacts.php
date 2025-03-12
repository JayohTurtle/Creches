<div class="container">
    <div class="articles">
        <div class="row">
            <div class="article contact-article col-md-3">
                <h5>Identité</h5>
                <?php if (isset($contact) && $contact instanceof Contact): ?>
                    <!-- Affichage des informations du contact -->
                    <p><strong>Nom: </strong> <?= htmlspecialchars($contact->getNom()) ?></p>
                    <p><strong>Contact: </strong> <?= htmlspecialchars($contact->getContact()) ?></p>
                    <p><strong>Email: </strong> <?= htmlspecialchars($contact->getEmail()) ?></p>
                    <p><strong>Téléphone: </strong> <?= htmlspecialchars($contact->getTelephone()) ?></p>
                    <p><strong>Sens: </strong> <?= htmlspecialchars($contact->getSens()) ?></p>
                    <p><strong>Site Internet: </strong> 
                        <a href="<?= htmlspecialchars($contact->getSiteInternet()) ?>" target="_blank">
                            <?= htmlspecialchars($contact->getSiteInternet()) ?>
                        </a>
                    </p>
                    <p><strong>SIREN: </strong> <?= htmlspecialchars($contact->getSiren()) ?></p>
                    <form method="POST" action="index.php?action=seeContact">
                        <input type="hidden" name="idContact" value="<?= htmlspecialchars($contact->getIdContact()) ?>">
                        <input type="hidden" name="sens" value="<?= htmlspecialchars($contact->getSens()) ?>">
                        <button type ="submit" class="btn btn-primary">Voir la fiche complète</button>
                    </form>
                <?php else: ?>
                    <p>Aucun contact trouvé.</p>
                <?php endif; ?>
            </div>
            <div class="article contact-article col-md-8">
                <!-- Affichage des commentaires (si disponibles) -->
                <h5>Commentaires</h5>
                <?php if (!empty($commentaires)): ?>
                    <ul>
                        <?php foreach ($commentaires as $commentaire): ?>
                            <li><?= htmlspecialchars($commentaire->getCommentaire()) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Aucun commentaire trouvé.</p>
                <?php endif; ?>

                <!-- Affichage des localisations (si disponibles) -->
                <?php if (!empty($localisations)): ?>
                <h5>Localisation des crèches</h5>
                <ul>
                    <?php foreach ($localisations as $localisation): ?>
                        <li>
                            Adresse : <?= htmlspecialchars($localisation->getAdresse()) ?>,
                            <?= htmlspecialchars($localisation->getVille()->getVille()) ?>,
                            <?= htmlspecialchars($localisation->getDepartement()->getDepartement()) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucune localisation trouvée.</p>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>
