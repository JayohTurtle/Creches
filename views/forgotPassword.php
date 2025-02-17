<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 350px; max-width: 60%;">

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


