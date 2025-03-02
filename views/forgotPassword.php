<div class="d-flex justify-content-center mt-5">
    <div class="articles col-md-3 d-flex justify-content-center">
        <div class="article" style="width: 350px; max-width: 90%;">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success_message']; ?></div>
            <?php unset($_SESSION['success_message']); // Supprime le message après affichage ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error_message']; ?></div>
            <?php unset($_SESSION['error_message']); // Supprime le message après affichage ?>
        <?php endif; ?>
            <h3 class="text-center mb-4">Mot de passe oublié</h3>
            <form method="POST" action="index.php?action=sendResetLink">
                <div class="mb-3 text-center form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" required>
                </div>
                <div>
                    <button type="submit" class="btn btn-secondary w-100">Envoyer</button>
                </div>
            </form>
        <div>
    </div>
</div>


