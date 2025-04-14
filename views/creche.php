
<div class="container">
    <h4>Creche</h4>
    <div class="row d-flex align-items-start">
        <?php if (isset($localisation) && $localisation instanceof Localisation): ?>
            <p><strong>Identifiant: </strong> <?= htmlspecialchars($localisation->getIdentifiant()) ?></p>
            <p><strong>Region: </strong> <?= htmlspecialchars($localisation->getRegion()->getRegion()) ?></p>
            <p><strong>Taille: </strong> <?= htmlspecialchars($localisation->getTaille()) ?></p>
            <p><strong>Statut: </strong> <?= htmlspecialchars($localisation->getStatut()) ?></p>
            
            <?php endif; ?>
    </div>

    <div class="form-group col-md-3 d-flex justify-content-between">
        <form method="POST" action="index.php?action=crecheAVendre">
            <input type="hidden" name="identifiant" value="<?= htmlspecialchars($localisation->getIdentifiant()) ?>">
            <button type="submit" class="btn btn-secondary small-button mt-3">A vendre</button>
        </form>
        <form method="POST" action="index.php?action=crecheVendue">
            <input type="hidden" name="identifiant" value="<?= htmlspecialchars($localisation->getIdentifiant()) ?>">
            <button type="submit" class="btn btn-primary small-button mt-3">Vendue</button>
        </form>
    </div>
</div>