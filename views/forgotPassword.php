<div class="container d-flex justify-content-center align-items-center">
    <div class="card shadow p-4" style="width: 350px; max-width: 90%;">
    <?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">Email envoyé avec succès !</div>
<?php endif; ?>

        <h3 class="text-center mb-4">Mot de passe oublié</h3>

        <form method="POST" action="index.php?action=sendResetLink">
            <div class="mb-3">
                <input type="email" name="email" placeholder="Votre email" required>
            </div>
            <div>
                <button type="submit" class="btn btn-secondary w-100">Envoyer</button>
            </div>
        </form>
    </div>
</div>


