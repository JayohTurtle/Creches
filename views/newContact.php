<div class="container">
    <?php if (!empty($_GET['error']) && $_GET['error'] === "contact_existe") : ?>
        <div id="error-message" style="color: red;">
            ⚠️ Ce contact existe déjà !
        </div>
    <?php endif; ?>

    <?php if (!empty($_GET['success']) && $_GET['success'] == 1) : ?>
        <div id="success-message" style="color: green;">
            ✅ Données ajoutées avec succès !
        </div>
    <?php endif; ?>
</div>
<div class="container form-container mt-1">
    <form id="form" method="POST" action="index.php?action=ajoutContact" novalidate>
        <h5 class="mt-2">Identité</h5>
        <div class="row form-row mt-3">
            <div class="form-group col-md-4">
                <label for="contact">Contact</label>
                <input type="text" class="form-control" id="contact" name="contact" value="<?= htmlspecialchars($_SESSION['form_data']['contact'] ?? '') ?>">
            </div>
            <div class="form-group col-md-5">
                <label for="nom">Nom du groupe</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($_SESSION['form_data']['nom'] ?? '') ?>">
            </div>
            <div class="form-group col-md-3">
                <label for="siren">SIREN</label>
                <input type="text" class="form-control" name="siren" id="siren" value="<?= htmlspecialchars($_SESSION['form_data']['siren'] ?? '') ?>">
            </div>
        </div>
        <div class="row form-row mt-3">
            <div class="form-group col-md-4">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_SESSION['form_data']['email'] ?? '') ?>">
            </div>
            <div class="form-group col-md-4">
                <label for="telephone">Téléphone</label>
                <input type="text" class="form-control" name="telephone" id="telephone" value="<?= htmlspecialchars($_SESSION['form_data']['telephone'] ?? '') ?>">
            </div>
            <div class="form-group col-md-4">
                <label for="site">Site internet</label>
                <input type="text" class="form-control" name="site" id="site" value="<?= htmlspecialchars($_SESSION['form_data']['site'] ?? '') ?>">
            </div>
        </div>
        <div class="row form-row mt-3">    
            <div class="form-group col-md-3">
                <label for="sens">Sens</label>
                <select class="form-control" name="sens" id="sens">
                    <option value="Neutre">Neutre</option>
                    <option value="Acheteur">Acheteur</option>
                    <option value="Vendeur">Vendeur</option>
                    <option value="Acheteur/Vendeur">Les deux</option>
                </select>
            </div>
            <div class="form-group col-md-9">
                <label for="comment">Commentaire</label>
                <textarea name="comment" id="comment" rows="2" class="form-control"></textarea>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary" id="contactEnvoi">Enregistrer</button>
        </div>
    </form>
</div>
<script src="js/validate_form_newContact.js" defer></script>

