<?php
require __DIR__ . '/../includes/auth.php';// Vérifie si l'utilisateur est connecté

?>

<div class="container">
    <div class="row d-flex align-items-start">
        <article class="col-md-3">
            <?php if (isset($_SESSION['userEmail'])) {
                echo "<p>Utilisateur : " . htmlspecialchars($_SESSION['userEmail']) . "</p>";
                 if($_SESSION['userRole'] === "user"){
                    echo "<p>L'équipe de YouInvest tient à vous souhaiter une excellente journée Monsieur le Président Directeur Général</br>";
                }
                echo "<p>Statut: ". htmlspecialchars($_SESSION['userRole']) . "</p>";
            } else {
                echo "<p>Utilisateur non connecté.</p>";
            }

            ?>
            <p class="ms-2 mt-3 fs-5">Agenda</p>
            <div class="mt-2 ms-2 calendar"></div>
            <p class="ms-2 mt-3 fs-5">Mails</p>
            <div class="mt-2 ms-2 mailbox"></div>
            <div class="mt-2 ms-2">
                <p>PNY réalisé : <?= number_format($commissions, 2, ',', ' ') ?> €</p>
            </div>
        </article>
        <article class="col-md-8 d-flex flex-column justify-content-center">
            <div id="map" style="height: 590px; width: 100%;"></div>
        </article>
        <article class="col-md-1 d-flex flex-column justify-content-center">
            <label>Filtres :</label>
            <div>
                <input type="checkbox" id="filtre-client" name="filtre-type" value="client" onchange="filtrerMarkers()">
                <label for="filtre-client">Clients</label>
            </div>
            <div>
                <input type="checkbox" id="filtre-vendeur" name="filtre-type" value="vendeur" onchange="filtrerMarkers()">
                <label for="filtre-vendeur">Vendeurs</label>
            </div>
            <div>
                <input type="checkbox" id="filtre-acheteur" name="filtre-type" value="acheteur" onchange="filtrerMarkers()">
                <label for="filtre-acheteur">Acheteurs</label>
            </div>
            <div>
                <input type="checkbox" id="filtre-neutre" name="filtre-type" value="neutre" onchange="filtrerMarkers()">
                <label for="filtre-neutre">Neutres</label>
            </div>
        </article>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>
<script src="js/map.js" defer></script>
<script src="js/accueil.js" defer></script>