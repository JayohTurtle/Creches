
<div class="container">
    <div class="articles">
        <div class="article">
            <h4>
                Acheteurs : <?= htmlspecialchars($zoneValue) ?>  - Ayant au moins <?= htmlspecialchars($nombreCreche == 0 ? 1 : $nombreCreche) ?> crèche(s) - (<?= htmlspecialchars($nombreContacts) ?>)
            </h4>
        </div>
        <div class="row mt-3">
            <?php if (!empty($contacts)): ?>
                <?php foreach ($contacts as $item): ?>
                    <?php if (!empty($item['contact'])): ?>
                        <?php $contact = $item['contact']; // Récupération directe de l'objet ?>
                        <div class="col-md-12">
                            <div class="article mb-3">
                                <h6 class="mb-2"> <a href="index.php?action=resultAcheteur&idContact=<?= urlencode($contact->getIdContact()) ?>">Contact</a></h6>
                                <div class="d-flex flex-wrap gap-3">
                                    <p><strong>Nom:</strong> <?= htmlspecialchars($contact->getNom()) ?></p>
                                    <p><strong>Contact:</strong> <?= htmlspecialchars($contact->getContact()) ?></p>
                                    <p><strong>Email:</strong> <?= htmlspecialchars($contact->getEmail()) ?></p>
                                    <p><strong>Téléphone:</strong> <?= htmlspecialchars($contact->getTelephone()) ?></p>
                                    <p><strong>Sens:</strong> <?= htmlspecialchars($contact->getSens()) ?></p>
                                    <p><strong>Site Internet:</strong> 
                                        <a href="<?= htmlspecialchars($contact->getSiteInternet()) ?>" target="_blank">
                                            <?= htmlspecialchars($contact->getSiteInternet()) ?>
                                        </a>
                                    </p>
                                    <p><strong>SIREN:</strong> <?= htmlspecialchars($contact->getSiren()) ?></p>
                                </div>

                                <?php if (!empty($item['interetsCreche'])): ?>
                                    <h6>Intérêts Crèches:</h6>
                                    <div class="d-flex flex-wrap gap-3">
                                        <?php foreach ($item['interetsCreche'] as $interet): ?>
                                            <p><strong>Niveau:</strong> <?= htmlspecialchars($interet->getNiveau()) ?></p>
                                            <p><strong>Identifiant:</strong> <?= htmlspecialchars($interet->getIdentifiant()) ?></p>
                                            <p><strong>Date:</strong> <?= htmlspecialchars($interet->getDateColonne()) ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p>Aucun intérêt crèche trouvé.</p>
                                <?php endif; ?>
                            <div class = "row">
                                <div class = "col-md-11">
                                    <?php if (!empty($item['interetsGroupe'])): ?>
                                        <h6>Intérêts Groupes:</h6>
                                        <div class="d-flex flex-wrap gap-3">
                                            <?php foreach ($item['interetsGroupe'] as $interet): ?>
                                                <p><strong>Niveau:</strong> <?= htmlspecialchars($interet->getNiveau()) ?></p>
                                                <p><strong>Nom du Groupe:</strong>  <?= htmlspecialchars($interet->getGroupe()) ?></p>
                                                <p><strong>Date:</strong> <?= htmlspecialchars($interet->getDateInteret()) ?></p>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <p>Aucun intérêt groupe trouvé.</p>
                                    <?php endif; ?>
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
