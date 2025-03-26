<div class="container">
    <h4>Creche</h4>
    <div class="row d-flex align-items-start">
        <?php if (isset($localisation) && $localisation instanceof Localisation): ?>
            <p><strong>Identifiant: </strong> <?= htmlspecialchars($localisation->getIdentifiant()) ?></p>
            <p><strong>Region: </strong> <?= htmlspecialchars($localisation->getRegion()->getRegion()) ?></p>
        <?php endif; ?>
    </div>
</div>