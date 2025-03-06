<div class="container">
    <div class = "row">            
        <div class = "articles col-md-3">
            <div class="article">
                <div class="row col-md-12">
                    <div class="mb-3 col-md-5">
                        <button type="button" class="btn btn-primary" id= "ajoutClient" onclick="ouvrirPopup('popupModifClient')">Modifier</button>
                    </div>
                </div>
                <h5>Identité</h5>
                <?php if ($contact instanceof Contact): ?>
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
                <?php endif; ?>
                <?php if ($clients instanceof Client): ?>
                    <div class="client">
                        <p><strong>Statut: </strong> <?= htmlspecialchars($client->getStatut()) ?></p>
                        <p><strong>Date Statut: </strong> <?= htmlspecialchars($clients->getDateStatut()) ?></p>
                        <p><strong>Valorisation: </strong> <?= htmlspecialchars($clients->getValorisation()) ?></p>
                        <p><strong>Commission: </strong> <?= htmlspecialchars($clients->getCommission()) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class = "articles col-md-5">
            <div class = "article">
                <?php if (!empty($localisations)): ?>
                    <h5>Localisation des crèches</h5>
                    <?php foreach ($localisations as $localisation): ?>
                        <div class="row">
                            <div class="col-md-10 mt-4">
                                <h6 >Adresse : <?= htmlspecialchars($localisation->getAdresse()) ?>,
                                <?= htmlspecialchars($localisation->getVille()->getVille()) ?>,
                                <?= htmlspecialchars($localisation->getDepartement()->getDepartement()) ?></h6>
                            </div>
                            <div class="col-md-1 mt-4">
                                <?php if ($clientData instanceof Client): ?>
                                    <button id="modifStatut-<?= $clientData->getIdContact(); ?>" class="btn-statut btn btn-primary">
                                        Statut
                                    </button>
                                    <div id="popupModifStatut-<?= $clientData->getIdContact(); ?>" class="popupModifStatut" style="display: none;">
                                        <div class="popup-content">
                                            <h5>Modifier le statut</h5>
                                            <form action="modifierStatut.php" method="POST">
                                                <label for="statut">Nouveau statut:</label>
                                                <select name="statut" id="statut">
                                                    <option value="Mandat signé">Mandat signé</option>
                                                    <option value="Mandat envoyé">Mandat envoyé</option>
                                                    <option value="Négociation">Négociation</option>
                                                    <option value="Approche">Approche</option>
                                                    <option value="Sous offre">Sous offre</option>
                                                    <option value="Vendu">Vendu</option>
                                                </select>
                                                <button type="submit" class="btn btn-success">Enregistrer</button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div>
                            <?php if (!empty($localisation->getInterets())): ?>
                                <div class="row">
                                    <?php foreach ($localisation->getInterets() as $interet): ?>
                                        <div class="col-md-12 mb-2">
                                            <div class="card text-white bg-secondary ws-100">
                                                <li class="ps-3 no-style">
                                                    <strong>Niveau:</strong> <?= htmlspecialchars($interet->getNiveau()) ?> -
                                                    <strong>Date:</strong> <?= date_format(date_create($interet->getDateInteret()), 'd-m-Y') ?><br>
                                                    <?php if ($interet->getContact() instanceof Contact): ?>
                                                        <strong>Contact:</strong> <?= htmlspecialchars($interet->getContact()->getContact()) ?><br>
                                                        <strong>Nom:</strong> <?= htmlspecialchars($interet->getContact()->getNom()) ?><br>
                                                        <strong>Email:</strong> <?= htmlspecialchars($interet->getContact()->getEmail()) ?><br>
                                                        <strong>Téléphone:</strong> <?= htmlspecialchars($interet->getContact()->getTelephone()) ?><br>
                                                    <?php else: ?>
                                                        <strong>Contact:</strong> Non trouvé
                                                    <?php endif; ?>
                                                </li>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <li>Aucun intérêt trouvé pour cette localisation.</li>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucune localisation trouvée.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="articles col-md-4">
            <div class="article">
                <?php if (!empty($interetsGroupe)): ?> 
                    <?php if ($contact instanceof Contact): ?>
                        <h5>Intérêt pour le groupe : <p><?= htmlspecialchars($contact->getNom()) ?></p></h5> 
                    <?php endif; ?>

                    <div class="localisation">
                        <ul>
                            <div class="row"> 
                                <?php foreach ($interetsGroupe as $interet): ?> 
                                    <div class="col-md-12 mb-2">
                                        <div class="card text-white bg-secondary ws-100">
                                            <li class="ps-3 no-style">
                                                <strong>Niveau:</strong> <?= htmlspecialchars($interet->getNiveau() ?? 'Non défini') ?> - 
                                                <strong>Date:</strong> <?= $interet->getDateInteret() ? date_format(date_create($interet->getDateInteret()), 'd-m-Y') : 'Non définie' ?><br>

                                                <?php if ($interet->getContact() instanceof Contact): ?>
                                                    <strong>Contact:</strong> <?= htmlspecialchars($interet->getContact()->getContact()) ?><br>
                                                    <strong>Nom:</strong> <?= htmlspecialchars($interet->getContact()->getNom()) ?><br>
                                                    <strong>Email:</strong> <?= htmlspecialchars($interet->getContact()->getEmail()) ?><br>
                                                    <strong>Téléphone:</strong> <?= htmlspecialchars($interet->getContact()->getTelephone()) ?><br>
                                                <?php else: ?>
                                                    <strong>Contact:</strong> Non trouvé
                                                <?php endif; ?>
                                            </li>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div> 
                        </ul>
                    </div>
                <?php else: ?>
                    <p>Aucun intérêt trouvé pour ce groupe.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class = "articles col-md-12">
        <div class="article">
            <div class="row col-md-12">
                <div class="mb-3 col-md-1">
                    <button id="boutonAjoutComment" type="button" class="btn btn-primary" onclick="ouvrirPopup('popupAjoutComment')">Ajouter</button>
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

<script src="js/clients.js" defer> </script>
