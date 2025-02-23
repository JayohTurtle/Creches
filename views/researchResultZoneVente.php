
<div class="container">
    <div class="articles">
        <div class="article">
            <h5>
                Crèches à vendre : <?= htmlspecialchars($zoneValue) ?>
            </h5>
        </div>
        <?php if (!empty($identifiants) && isset($identifiants[0]['localisation']) && $identifiants[0]['localisation'] instanceof Localisation): ?>
            <div class="row g-3"> 
                <?php foreach ($identifiants as $item): ?>
                    <?php $localisation = $item['localisation']; ?>
                    <div class="col-md-12">
                        <div class="article p-3 rounded shadow-sm">
                            <p><strong>Identifiant :</strong> <?= htmlspecialchars($localisation->getIdentifiant()) ?></p>
                            
                            <!-- ✅ Afficher la distance uniquement si elle est définie -->
                            <?php if (isset($item['distance']) && !is_null($item['distance'])): ?>
                                <p><strong>Distance :</strong> <?= number_format($item['distance'], 2) ?> km</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun résultat trouvé.</p>
        <?php endif; ?>
    </div>
</div>




