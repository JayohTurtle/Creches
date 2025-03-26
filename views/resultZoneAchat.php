
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
                        <div class="col-md-12">
                            <div class="article mb-3">
                                <h5 class="mb-2"> Contact</h5>
                                <p>
                                    <a href="index.php?action=researchAcheteurs&idContact=<?= urlencode($contact->getIdContact()) ?>">
                                        <strong><?= htmlspecialchars($contact->getNom()) ?> (<?= htmlspecialchars($contact->getContact()) ?>)</strong>
                                    </a>
                                </p>
                                <p style="display: flex; align-items: center; gap: 8px;">
                                    Email :
                                    <span id="emailACopier_<?= urlencode($contact->getEmail()) ?>">
                                        <?= htmlspecialchars($contact->getEmail()) ?>
                                    </span>
                                    <img class="iconCopie" src="assets/images/copier.png" alt="Copier"
                                        onclick="copierTextePopup('emailACopier_<?= urlencode($contact->getEmail()) ?>', this)">
                                </p>
                                <p><strong>Téléphone:</strong> <?= htmlspecialchars($contact->getTelephone()) ?></p>
                                <?php if (!empty($item['interetsCreche']['interetsCreche'])): ?>
                                    <h6>Intérêts Crèches:</h6>
                                    <div class="flex-wrap gap-3">
                                        <?php foreach ($item['interetsCreche']['interetsCreche'] as $interet): ?>
                                            <p><strong>Niveau:</strong> <?= htmlspecialchars($interet->getNiveau()) ?></p>
                                            <p><strong>Identifiant:</strong> <?= htmlspecialchars($interet->getLocalisation()->getIdentifiant()) ?></p>
                                            <p><strong>Date:</strong> <?= htmlspecialchars($interet->getDateColonneFormatFr()) ?></p><br>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p>Aucun intérêt crèche trouvé.</p>
                                <?php endif; ?>
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