<div class="container">
    <div class="articles">
        <div class="article">
            <h5>Identifiant de la crèche : <?= htmlspecialchars($identifiant) ?></h5>
        </div>
        <div class="article">
            <h6>Contacts intéressés</h6>
        </div>
        <?php if (!empty($contacts)): ?>
            <div class="row g-3"> 
                <?php foreach ($contacts as $contact): ?>
                    <div class="col-md-4"> <!-- Ajout de w-100 pour éviter une réduction de largeur -->
                        <div class="article p-3 rounded shadow-sm">
                            <p><strong>Contact :</strong> <?= htmlspecialchars($contact->getContact()) ?></p>
                            <p><strong>Nom :</strong> <?= htmlspecialchars($contact->getNom()) ?></p>
                            <p><strong>Téléphone :</strong> <?= htmlspecialchars($contact->getTelephone()) ?></p>
                            <p><strong>Email :</strong> <?= htmlspecialchars($contact->getEmail()) ?></p>
                            <p><strong>Niveau :</strong> <?= htmlspecialchars($contact->getNiveau()) ?></p>
                            <p><strong>Nombre de crèche(s) :</strong> <?= htmlspecialchars($contact->getNbCreches()) ?></p>
                            <?php if ($contact->getDepartement()): ?>
                                <p><strong>Est intéressé par le département :</strong> <?= htmlspecialchars($contact->getDepartement()->getDepartement()) ?></p>
                            <?php endif; ?>
                            <?php if ($contact->getVille()): ?>
                                <p><strong>Est intéressé par la ville :</strong> <?= htmlspecialchars($contact->getVille()->getVille()) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">Aucun contact intéressé par cette crèche.</p>
        <?php endif; ?>
    </div>
</div>



