<div class="container d-flex justify-content-center align-items-center">
    <div class="card shadow p-4" style="width: 350px; max-width: 90%;">
        <h3 class="text-center mb-4">Création du mot de passe</h3>
        <h5 class="text-center mb-4">Le mot de passe doit être modifié lors de la première connexion</h5>
        
        <form method="POST" action="index.php?action=changePassword">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="form-group mb-3">
                <label for="newPassword">Nouveau mot de passe</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
            </div>

            <div class="form-group mb-3">
                <label for="confirmPassword">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit" class="btn btn-secondary w-100">Changer le mot de passe</button>
        </form>
    </div>
</div>
