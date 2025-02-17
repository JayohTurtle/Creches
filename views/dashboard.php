<?php
require __DIR__ . '/../includes/auth.php';// Vérifie si l'utilisateur est connecté

?>



<div class="container">
    <?php if (isset($_SESSION['user_email'])) {
        echo "<p>Utilisateur : " . htmlspecialchars($_SESSION['user_email']) . "</p>";
    } else {
        echo "<p>Utilisateur non connecté.</p>";
    }
    ?>
    <article class="col-md-3 mt-25 creches">
        <p class="ms-3 mt-25 fs-4">A vendre</p>
        <ul class="ms-3 mt-25 list-unstyled">
            <li>Nombre de crèches:</li>
            <li>PNB potentiel:</li>
        </ul>
        <p class="ms-3 mt-25 fs-4">Sous offre</p>
        <ul class="ms-3 mt-25 list-unstyled">
            <li>Nombre de crèches:</li>
            <li>PNB attendu:</li>
        </ul>
        <p class="ms-3 mt-25 fs-4">Vendues</p>
        <ul class="ms-3 mt-25 list-unstyled">
            <li>Nombre de crèches:</li>
            <li>PNB réalisé:</li>
        </ul>
    </article>
    <article class="col-md-9 mt-25">
</div>