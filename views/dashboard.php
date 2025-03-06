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
    <div class="row d-flex align-items-start justify-content-center">
        <!-- Colonne de gauche -->
        <article class="col-md-3 mt-3 creches d-flex flex-column justify-content-center">
            <p class="ms-3 mt-3 fs-4">A vendre</p>
            <p class="ms-3 mt-3 fs-5">Mandats signés</p>
            <ul class="ms-3 mt-2 list-unstyled">
                <li>Client(s)</li>
                <li>Nombre de crèches <strong><?= $nbCrecheAvendre; ?></strong></li>
                <li>PNY potentiel <strong><?= number_format($totalCommission, 2, ',', ' '); ?> €</strong></li>
            </ul>
            <p class="ms-3 mt-3 fs-5">Mandats envoyés</p>
            <ul class="ms-3 mt-2 list-unstyled">
                <li>Client(s)</li>
                <li>Nombre de crèches <strong><?= $nbCrecheAvendre; ?></strong></li>
                <li>PNY potentiel <strong><?= number_format($totalCommission, 2, ',', ' '); ?> €</strong></li>
            </ul>
            <p class="ms-3 mt-3 fs-5">Approche</p>
            <ul class="ms-3 mt-2 list-unstyled">
                <li>Client(s)</li>
                <li>Nombre de crèches <strong><?= $nbCrecheAvendre; ?></strong></li>
                <li>PNY potentiel <strong><?= number_format($totalCommission, 2, ',', ' '); ?> €</strong></li>
            </ul>
        </article>
        <!-- Colonne de droite -->
        <article class="col-md-7 d-flex flex-column justify-content-center">
            <div id="map" style="height: 590px; width: 100%;"></div>
        </article>
        <article class="col-md-2 mt-3 creches d-flex flex-column justify-content-center">
            <p class="ms-3 mt-2 fs-4">Sous offre</p>
            <ul class="ms-3 mt-2 list-unstyled">
                <li>Nombre de crèches:</li>
                <li>PNY attendu:</li>
            </ul>
            <p class="ms-3 mt-3 fs-4">Vendu</p>
            <ul class="ms-3 mt-2 list-unstyled">
                <li>Nombre de crèches:</li>
                <li>PNY réalisé:</li>
            </ul>
        </article>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>
<script src="js/map.js" defer></script>
    