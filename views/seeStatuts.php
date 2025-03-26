<div class="container">
    <div class="articles">
        <div class="article">
        <?php
            if (!empty($clients)  && ($statut!=="Tous")) {
                // Récupérer le niveau de la première occurrence
                $statut = $clients[0]->getStatut();
            } else {
                $statut = "Tous";
            }
            ?>
            <h5>
                Clients par statut: <?= htmlspecialchars($statut) ?>
            </h5>
        </div>
        <div class="row">
            <?php foreach ($clients as $client): ?>
                <div class="Article mt-3 col-md-4  d-flex flex-column align-items-center">
                    <?php if($statut === "Tous"):?>
                        <strong> <p><?= htmlspecialchars($client->getStatut())?></p></strong>
                    <?php endif;?>
                    <a href="index.php?action=researchVendeurs&idContact=<?= urlencode($client->getIdContact()) ?>">
                        <p><strong><?= htmlspecialchars($client->getContact()->getNom()) ?> (<?= htmlspecialchars($client->getContact()->getContact()) ?></strong>) </p>
                    </a>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <span id="emailACopier_<?= htmlspecialchars($client->getContact()->getEmail()) ?>"><?= htmlspecialchars($client->getContact()->getEmail()) ?></span>
                        <img class="iconCopie" src="assets/images/copier.png" alt="Copier" onclick="copierTextePopup('emailACopier_<?= htmlspecialchars($client->getContact()->getEmail()) ?>', this)">
                    </p>
                    <p><?= htmlspecialchars($client->getContact()->getTelephone())?></p>
                    <p><?= $client->getNombreCreches() ?> crèches</p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script src="js/iconCopy.js" defer> </script>