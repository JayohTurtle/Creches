
<div class="container">
    <div class="articles">
        <div class="article">
            <h5>
                Crèches à vendre : <?= htmlspecialchars($zoneValue) ?> - (<?= htmlspecialchars($nombreLocalisations) ?>)
            </h5>
        </div>
        <?php if (!empty($localisations) && $localisations[0] instanceof Localisation): ?>
            <div class="mt-3 row g-3"> 
                <?php foreach ($localisations as $localisation): ?>
                    <div class="article p-3 rounded shadow-sm">
                        <div class="row">
                            <div class="col-md-9">
                                <a href="index.php?action=creche&idLocalisation=<?= htmlspecialchars($localisation->getIdLocalisation())?>">
                                    <p><?= htmlspecialchars($localisation->getIdentifiant()) ?> , <?= htmlspecialchars($localisation->getDepartement()->getDepartement()) ?> , <?= htmlspecialchars($localisation->getRegion()->getRegion()) ?> >>> <?= htmlspecialchars($localisation->getTaille()) ?></p>
                                    <!-- ✅ Afficher la distance uniquement si elle est définie -->
                                    <?php if (isset($item['distance']) && !is_null($item['distance'])): ?>
                                        <p><strong>Distance :</strong> <?= number_format($item['distance'], 2) ?> km</p>
                                    <?php endif; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun résultat trouvé.</p>
        <?php endif; ?>
    </div>
</div>




