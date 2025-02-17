
<form method="POST">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    <input type="password" name="new_password" placeholder="Nouveau mot de passe" required>
    <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
    <button type="submit">Changer le mot de passe</button>
</form>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

