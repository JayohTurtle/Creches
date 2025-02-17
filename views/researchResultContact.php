
<div class = "container">
    <div class = "row">
        <div class = "articles col-md-4">
            <div class="article">
                <h5>Identité</h5>
                <?php if ($contact instanceof Contact): ?>
                    <p><strong>Nom: </strong> <?= htmlspecialchars($contact->getNom()) ?></p>
                    <p><strong>Contact: </strong> <?= htmlspecialchars($contact->getContact()) ?></p>
                    <p><strong>SIREN: </strong> <?= htmlspecialchars($contact->getSiren()) ?></p>
                    <p><strong>Email: </strong> <?= htmlspecialchars($contact->getEmail()) ?></p>
                    <p><strong>Téléphone: </strong> <?= htmlspecialchars($contact->getTelephone()) ?></p>
                    <p><strong>Sens: </strong> <?= htmlspecialchars($contact->getSens()) ?></p>
                    <p><strong>Site Internet: </strong> 
                        <a href="<?= htmlspecialchars($contact->getSiteInternet()) ?>" target="_blank">
                            <?= htmlspecialchars($contact->getSiteInternet()) ?>
                        </a>
                    </p>
                <?php else: ?>
                    <p>Aucun contact trouvé.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class = "articles col-md-8">
            <div class="article">
                <h5>Commentaires</h5>
                <ul>
                    <li></li>
                </ul>
            </div>
        </div>
    </div>
    <div>
        <div class = "articles mt-3">
            <div class = "article">
                <h5>Localisation des crèches</h5>
            </div>
        </div>
    </div>
    <div>
        <div class = "articles mt-3">
            <div class = "article">
                <h5>Intérêt</h5>
            </div>
        </div>
    </div>
</div>