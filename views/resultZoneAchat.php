
<div class="container">
    <div class="articles">
        <div class="article">
            <h4>
                Acheteurs : <?= htmlspecialchars($zoneValue) ?>  - Ayant au moins <?= htmlspecialchars($nombreCreche == 0 ? 1 : $nombreCreche) ?> crèche(s) - (<?= htmlspecialchars($nombreContacts) ?>)
            </h4>
        </div>
        <button onclick="copierTousLesEmails()" class="btn btn-primary mb-2 mt-2">Copier tous les emails</button>
        <div class="row mt-3">
            <?php if (!empty($contacts)): ?>
                <?php foreach ($contacts as $item): ?>
                    <?php if (!empty($item['contact'])): ?>
                        <?php $contact = $item['contact']; // Récupération directe de l'objet ?>
                        <?php $interetsCreche = $item['interetsCreche']['interetsCreche'] ?? []; ?>
                        <?php $commentaires = $item['commentaires'] ?? []; ?>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="article mb-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-2"> Contact</h5>
                                        <p>
                                            <a href="index.php?action=researchAcheteurs&idContact=<?= urlencode($contact->getIdContact()) ?>">
                                                <strong><?= htmlspecialchars($contact->getNom()) ?> (<?= htmlspecialchars($contact->getContact()) ?>)</strong>
                                            </a>
                                        </p>
                                        <p><strong>Sens :</strong><?= htmlspecialchars($contact->getSens()) ?> </p>
                                        <p style="display: flex; align-items: center; gap: 8px;">
                                            Email :
                                            <span id="emailACopier_<?= urlencode($contact->getEmail()) ?>">
                                                <?= htmlspecialchars($contact->getEmail()) ?>
                                            </span>
                                            <img class="iconCopie" src="assets/images/copier.png" alt="Copier"
                                                onclick="copierTextePopup('emailACopier_<?= urlencode($contact->getEmail()) ?>', this)">
                                        </p>
                                        <p><strong>Téléphone:</strong> <?= htmlspecialchars($contact->getTelephone()) ?></p>
                                        <?php if (!empty($interetsCreche)): ?>
                                            <h6>Intérêts Crèches:</h6>
                                            <div class="flex-wrap gap-3">
                                                <?php foreach ($interetsCreche as $interetCreche): ?>
                                                    <p><strong>Niveau:</strong> <?= htmlspecialchars($interetCreche->getNiveau()) ?></p>
                                                    <p><strong>Identifiant:</strong> <?= htmlspecialchars($interetCreche->getLocalisation()->getIdentifiant()) ?></p>
                                                    <p><strong>Date:</strong> <?= htmlspecialchars($interetCreche->getDateColonneFormatFr()) ?></p><br>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <p>Aucun intérêt crèche trouvé.</p>
                                        <?php endif; ?>
                                        <h6>Commentaires</h5>
                                        <?php if (!empty($commentaires)): ?>
                                            <?php foreach ($commentaires as $comment): ?>
                                                <li>Le <?= htmlspecialchars($comment->getDateCommentFormatFr()); ?> 
                                                    , <?= htmlspecialchars($comment->getOperateur()) ?> a écrit :
                                                    <?= htmlspecialchars($comment->getCommentaire()) ?>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li>Aucun commentaire trouvé.</li>
                                        <?php endif; ?>
                                    </div>
                                    <input type="checkbox" class="form-check-input email-checkbox" data-email="<?= htmlspecialchars($contact->getEmail()) ?>">
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="ms-2">Aucun contact trouvé.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="js/copyAllEmails.js" defer> </script>
<script src="js/iconCopy.js" defer> </script>