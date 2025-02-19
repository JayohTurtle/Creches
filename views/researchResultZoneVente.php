<div class="container">
    <div class="articles">
        <div class="article">
            <h5>Crèches à vendre à : <?= htmlspecialchars($ville) ?></h5>
        </div>
        <?php if (!empty($identifiants) && $identifiants[0] instanceof Localisation): ?>
            <div class="row g-3"> 
                <?php foreach ($identifiants as $identifiant): ?>
                    <div class="col-md-12">
                        <div class="article p-3 rounded shadow-sm">
                            <p><strong>Identifiant :</strong> <?= htmlspecialchars($identifiant->getIdentifiant()) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun résultat trouvé.</p>
        <?php endif; ?>
    </div>
</div>

