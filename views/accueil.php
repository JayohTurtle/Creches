<?php
require __DIR__ . '/../includes/auth.php';// Vérifie si l'utilisateur est connecté

?>

<div class="container">
    <div class="row d-flex align-items-start">
        <article class="col-md-3">
            <?php if (isset($_SESSION['userEmail'])) {
                echo "<p>Utilisateur : " . htmlspecialchars($_SESSION['userEmail']) . "</p>";
                 if($_SESSION['userRole'] === "user"){
                    echo "<p>L'équipe de YouInvest tient à vous souhaiter une excellente journée pleine de réussites professionnelles Monsieur le Président Directeur Général</br>";
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
        </article>
        <article class="col-md-8 d-flex flex-column justify-content-center">
            <div id="map" style="height: 590px; width: 100%;"></div>
        </article>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>
<script src="js/map.js" defer></script>