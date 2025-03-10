<div class="container">
    <div class = "row">
        <div class = "articles col-md-3">
            <div class="article client-article">
                <div class="row col-md-12">
                    <div class="mb-3 col-md-5">
                        <button type="button" class="btn btn-primary" id= "ajoutContact" onclick="ouvrirPopup('popupModifContact')">Modifier</button>
                    </div>
                </div>
                <h5>Identité</h5>
                <?php if (isset($contact) && $contact instanceof Contact): ?>
                    <p><strong>Nom: </strong> <?= htmlspecialchars($contact->getNom()) ?></p>
                    <p><strong>Contact: </strong> <?= htmlspecialchars($contact->getContact()) ?></p>
                    <p><strong>Email: </strong> <?= htmlspecialchars($contact->getEmail()) ?></p>
                    <p><strong>Téléphone: </strong> <?= htmlspecialchars($contact->getTelephone()) ?></p>
                    <p><strong>Sens: </strong> <?= htmlspecialchars($contact->getSens()) ?></p>
                    <p><strong>Site Internet: </strong> 
                        <a href="<?= htmlspecialchars($contact->getSiteInternet()) ?>" target="_blank">
                            <?= htmlspecialchars($contact->getSiteInternet()) ?>
                        </a>
                    <p></p>
                    <p><strong>SIREN: </strong> <?= htmlspecialchars($contact->getSiren()) ?></p>
                <?php else: ?>
                    <p>Aucun contact trouvé.</p>
                <?php endif; ?>
                <?php if (isset($clientData) && $clientData instanceof Client): ?>
                    <p><strong>Statut: </strong> <?= htmlspecialchars($clientData->getStatut()) ?></p>
                    <p><strong>Date du statut: </strong> <?= htmlspecialchars($clientData->getDateStatutFormatFr()) ?></p>
                <?php endif; ?>
                <p><strong>Nombre de crèches: </strong><?= htmlspecialchars($nombreCreches)?></p>
            </div>
        </div>
        <div class = "articles col-md-3">
            <div class="article">
                <div class="row col-md-11">
                    <div class="mb-3 col-md-1">
                        <button type="button" class="btn btn-primary" onclick="ouvrirPopup('popupModifInteretGroupe')">Modifier</button>
                    </div>
                </div>
                <h5 >Intérêts sur le groupe</h5>
                <ul>
                    <?php if (!empty($interetsGroupe)): ?>
                        <?php foreach ($interetsGroupe as $interetGroupe): ?>
                                <?= htmlspecialchars($interetGroupe->getOperateur()) ?>
                                <?= htmlspecialchars($comment->getCommentaire()) ?>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Aucun interet trouvé.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class = "articles col-md-6">
            <div class="article">
                <div class="row col-md-11">
                    <div class="mb-3 col-md-1">
                        <button type="button" class="btn btn-primary" onclick="ouvrirPopup('popupModifInteretCreche')">Modifier</button>
                    </div>
                </div>
                <h5 >Intérêts sur les crèches</h5>
                <ul>
                    <?php if (!empty($localisations)): ?>
                        <?php foreach ($localisations as $localisation): ?>
                                <li><?= htmlspecialchars($localisation->getIdentifiant()) ?></li>
                            
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Aucun intérêt trouvé.
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class = "articles col-md-9 mt-3">
        <div class="article">
            <div class="row col-md-9">
                <div class="mb-3 col-md-1">
                    <button type="button" class="btn btn-primary" onclick="ouvrirPopup('popupAjoutComment')">Ajouter</button>
                </div>
            </div>
            <h5 >Commentaires</h5>
            <ul>
                <?php if (!empty($commentaires)): ?>
                    <?php foreach ($commentaires as $comment): ?>
                        <li>Le <?php echo htmlspecialchars($comment->getDateCommentFormatFr()); ?> 
                            , <?= htmlspecialchars($comment->getOperateur()) ?> a écrit :
                            <?= htmlspecialchars($comment->getCommentaire()) ?>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Aucun commentaire trouvé.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>