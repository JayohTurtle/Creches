<div class="container">
    <div class="articles">
        <div class="article">
            <h4>Niveau : 
                <?php 
                    if (!empty($contacts) && is_array($contacts)) {
                        $firstContact = $contacts[0];
                        $localisations = $firstContact->getLocalisations();
                        if (!empty($localisations) && is_array($localisations)) {
                            echo htmlspecialchars($localisations[0]->getNiveau());
                        } else {
                            echo "Niveau inconnu";
                        }
                    } else {
                        echo "Aucun contact disponible";
                    }
                ?>
            </h4>
        </div>
        <?php foreach ($contacts as $contact): ?>
            <div class="article ms-3 mb-3">
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
                <p>Téléphone : <?= htmlspecialchars($contact->getTelephone()) ?></p>
                <p><strong>Offre(s) pour :</strong></p>
                <ul>
                    <?php foreach ($contact->getLocalisations() as $localisation): ?>
                        <li>
                            <a href="index.php?action=creche&idLocalisation=<?= urlencode($localisation->getIdLocalisation()) ?>">
                                <?= htmlspecialchars($localisation->getIdentifiant()) ?> - 
                                <?= htmlspecialchars($localisation->getDepartement()) ?> 
                                (<?= htmlspecialchars($localisation->getRegion()) ?>)
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="js/iconCopy.js" defer> </script>