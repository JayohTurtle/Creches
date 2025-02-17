<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="articles col-md-4">
        <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']);
            ?>
        </div>
        <?php endif; ?>
        <div class="article p-4" style="width: 350px; max-width: 90%;">
            <form method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <input type="password" name="new_password" placeholder="Nouveau mot de passe" required>
                <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
                <button type="submit">Changer le mot de passe</button>
            </form>
        </div>
    </div>
</div>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

