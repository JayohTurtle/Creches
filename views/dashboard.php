<?php
require __DIR__ . '/../includes/auth.php';// Vérifie si l'utilisateur est connecté

?>

<div class="container">
    <?php if (isset($_SESSION['userEmail'])) {
        echo "<p>Utilisateur : " . htmlspecialchars($_SESSION['userEmail']) . "</p>";
    } else {
        echo "<p>Utilisateur non connecté.</p>";
    }
    ?>
    <div class="row d-flex align-items-start">
        <!-- Colonne de gauche -->
        <article class="col-md-3 mt-3 creches">
        <p class="ms-3 mt-3 fs-4">A vendre</p>
            <ul class="ms-3 mt-3 list-unstyled">
                <li>Nombre de crèches: <strong><?= $nbCrecheAvendre; ?></strong></li>
                <li>PNB potentiel: <strong><?= number_format($totalCommission, 2, ',', ' '); ?> €</strong></li>
            </ul>
            <p class="ms-3 mt-3 fs-4">Sous offre</p>
            <ul class="ms-3 mt-3 list-unstyled">
                <li>Nombre de crèches:</li>
                <li>PNB attendu:</li>
            </ul>
            <p class="ms-3 mt-3 fs-4">Vendues</p>
            <ul class="ms-3 mt-3 list-unstyled">
                <li>Nombre de crèches:</li>
                <li>PNB réalisé:</li>
            </ul>
        </article>

        <!-- Colonne de droite -->
        <article class="col-md-8">
            <div id="map" style="height: 590px; width: 100%;"></div>
        </article>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>
<script src="js/map.js" defer></script>
    