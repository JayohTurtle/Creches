<div class="container">
    <div class = "articles col-md-12">
        <?php if (isset($localisation) && $localisation instanceof Localisation): ?>
            <h4>Intérets sur la crèche : <?= htmlspecialchars($localisation->getIdentifiant()) ?> </h4>
        <?php endif; ?>
        <div class = "row mt-3">
            <div class="article client-article col-md-3">
                <h5>Identité</h5>
                <?php if (isset($contactClient) && $contactClient instanceof Contact): ?>
                    <p><strong>Nom: </strong> <?= htmlspecialchars($contactClient->getNom()) ?></p>
                    <p><strong>Contact: </strong> <?= htmlspecialchars($contactClient->getContact()) ?></p>
                    <p><strong>Email: </strong> <?= htmlspecialchars($contactClient->getEmail()) ?></p>
                    <p><strong>Téléphone: </strong> <?= htmlspecialchars($contactClient->getTelephone()) ?></p>
                    <p><strong>Sens: </strong> <?= htmlspecialchars($contactClient->getSens()) ?></p>
                    <p><strong>Site Internet: </strong> 
                        <a href="<?= htmlspecialchars($contactClient->getSiteInternet()) ?>" target="_blank">
                            <?= htmlspecialchars($contactClient->getSiteInternet()) ?>
                        </a>
                    <p></p>
                    <p><strong>SIREN: </strong> <?= htmlspecialchars($contactClient->getSiren()) ?></p>
                <?php else: ?>
                    <p>Aucun contact trouvé.</p>
                <?php endif; ?>
                <?php if (isset($client) && $client instanceof Client): ?>
                    <p><strong>Statut: </strong> <?= htmlspecialchars($client->getStatut()) ?></p>
                    <p><strong>Date du statut: </strong> <?= htmlspecialchars($client->getDateStatutFormatFr()) ?></p>
                <?php endif; ?>
                <p><strong>Nombre de crèches: </strong><?= htmlspecialchars($nombreCreches)?></p>
                <div class="row col-md-12">
                    <div class="mb-3 col-md-5">
                        <button type="button" class="btn btn-primary" id= "ajoutContact" onclick="ouvrirPopup('popupModifContact')">Modifier</button>
                    </div>
                </div>
            </div>
            <div class="articles col-md-3">
                <h5>Acheteur(s)</h5>
                <?php foreach($acheteurs as $acheteur): ?>   
                    <div class="article client-article">
                        <?php if (isset($acheteurs) && $acheteurs instanceof Contact): ?>
                            <p><strong>Nom: </strong> <?= htmlspecialchars($acheteurs->getNom()) ?></p>
                            <p><strong>Contact: </strong> <?= htmlspecialchars($acheteurs->getContact()) ?></p>
                            <p><strong>Email: </strong> <?= htmlspecialchars($acheteurs->getEmail()) ?></p>
                            <p><strong>Téléphone: </strong> <?= htmlspecialchars($acheteurs->getTelephone()) ?></p>
                            <p><strong>Site Internet: </strong> 
                                <a href="<?= htmlspecialchars($acheteurs->getSiteInternet()) ?>" target="_blank">
                                    <?= htmlspecialchars($acheteurs->getSiteInternet()) ?>
                                </a>
                            <p><strong>Intérêt: </strong><?= htmlspecialchars($interetsCreche->getNiveau()) ?></p>
                            <p><strong>Date: </strong><?= htmlspecialchars($interetsCreche->getDateStatutFormatFr()) ?></p>
                        <?php else: ?>
                        <p>Aucun contact trouvé.</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>