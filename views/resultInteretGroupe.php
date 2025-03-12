<div class="container">
    <div class="articles">
        <div class="article">
            <h5>Nom du groupe : <?= htmlspecialchars($groupe) ?></h5>
        </div>
        <div class="article">
            <h6>Contacts intéressés</h6>
        </div>
        <?php if (!empty($contacts)): ?>
            <div class="row g-3">
                <?php foreach ($contacts as $contact): ?>
                    <div class="col-md-4">
                        <div class="article p-3 rounded"> 
                            <p><strong>Contact :</strong> <?= htmlspecialchars($contact->getContact()) ?></p>
                            <p><strong>Nom :</strong> <?= htmlspecialchars($contact->getNom()) ?></p>
                            <p><strong>Téléphone :</strong> <?= htmlspecialchars($contact->getTelephone()) ?></p>
                            <p><strong>Email :</strong> <?= htmlspecialchars($contact->getEmail()) ?></p>
                            <p><strong>Niveau :</strong> <?= htmlspecialchars($contact->getNiveau()) ?></p>
                            <p><strong>Nombre de crèche(s) :</strong> <?= htmlspecialchars($contact->getNbCreches()) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">Aucun contact intéressé par ce groupe.</p>
        <?php endif; ?>
    </div>
</div>