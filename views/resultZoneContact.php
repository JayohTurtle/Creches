<div class="container">
    <div class="articles">
        <div class="article">
            <h4>
                Contacts : <?= htmlspecialchars($zoneValue) ?>  - Ayant au moins <?= htmlspecialchars($nombreCreche == 0 ? 1 : $nombreCreche) ?> crèche(s) - (<?= htmlspecialchars($nombreContacts) ?>)
            </h4>
        </div>
        <form id="emailForm" action="index.php?action=actionContact" method="POST">
            <input type="hidden" name="emails" id="emailsInput">
            <input type="hidden" name="zoneValue" value="<?= htmlspecialchars($zoneValue) ?>">
            <input type="hidden" name="nombreCreche" value="<?= htmlspecialchars($nombreCreche == 0 ? 1 : $nombreCreche) ?>">
            <input type="hidden" name="zoneVille" value="<?= htmlspecialchars($zoneVille) ?>">
            <input type="hidden" name="zoneType" value="<?= htmlspecialchars($zoneType) ?>">
            <input type="hidden" name="rayon" value="<?= htmlspecialchars($rayon) ?>">
            <button type="button" onclick="copierTousLesEmails()" class="btn btn-primary mb-2 mt-2">
                Copier tous les emails et envoyer
            </button>
        </form>
        <div class="row mt-3">
        <?php if (!empty($contacts)): ?>
            <?php foreach ($contacts as $item): ?>
                <?php if (!empty($item['contact'])): ?>
                    <?php $contact = $item['contact']; // Récupération directe de l'objet ?>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="article mb-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <p>
                                        <a href="index.php?action=seeContact&idContact=<?= urlencode($contact->getIdContact()) ?>">
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
<script src="js/copyAllEmails.js" defer> </script>
<script src="js/iconCopy.js" defer> </script>