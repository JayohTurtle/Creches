<div class="container form-container mt-1">
    <?php if ($success = true) : ?>
        <div  id="success-message">
            ✅ Contact ajouté !
        </div>
    <?php endif; ?>
</div>
    <div class="container form-container mt-1">
        <form id="formVendeur" method="POST" action="index.php?action=ajoutVendeur">
            <h5 class="mt-3">Localisation de/des crèches</h5>
            <div class="row form-row">
                <div class="form-group col-md-2" id="statutVendeur">
                    <label for="statut">Statut</label>
                    <select class="form-control" name="statut" id="statut">
                        <option value="Approche">Approche</option>
                        <option value="Négociation">Négociation</option>
                        <option value="Mandat envoyé">Mandat envoyé</option>
                        <option value="Mandat signé">Mandat signé</option>
                        <option value="Vendu">Vendu</option>
                    </select>
                </div>
                <div class="form-group col-md-3" id ="valoVendeur">
                    <label for="valorisation">Valorisation</label>
                    <input class="form-control" id="valorisation" name="valorisation">
                </div>
                <div class="form-group col-md-3" id="commVendeur">
                    <label for="commission">Commission</label>
                    <input class="form-control" id="commission" name="commission">
                </div>
                <input type="hidden" name="idContact" value="<?= $idContact; ?>">
                <input type="hidden" name="nom" value="<?= $nom; ?>">
                <div class="col-md-3 d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </div>
            <h6>Vente</h6>
            <div class="form-group col-md-3">
                <label  for="groupe">Groupe</label>
                <input class="ms-3" type="checkbox" id="groupe" name="groupe" checked>
            </div>
            <div class="row form-row mt-3 align-items-center" id="location">
                <div class="form-group col-md-1 d-flex pt-4 justify-content-end" id="solo">
                    <input type="checkbox" id="solo" name="solo[]" value="1">
                </div>
                <div class="form-group col-md-2">
                    <label for="villeVendeur">Ville</label>
                    <input class="form-control" list="villesVendeur" id="villeVendeur" name="villeVendeur[]" autocomplete="off">
                    <datalist id="villesVendeur"></datalist>
                </div>
                <div class="form-group col-md-1">
                    <label for="codePostalVendeur">Code postal</label>
                    <input class="form-control" type="text" id="codePostalVendeur" list="codePostauxVendeur" name="codePostalVendeur[]" autocomplete="off">
                    <datalist id="codePostauxVendeur"></datalist>
                </div>
                <div class="form-group col-md-3">
                    <label for="adresse">Adresse</label>
                    <input class="form-control" id="adresse" name="adresse[]">
                </div>
                <div class="form-group col-md-2">
                    <label for="taille">Taille</label>
                    <select class="form-control" name="taille[]" id="taille">
                        <option value="Micro-crèche">Micro-crèche</option>
                        <option value="Crèche">Crèche</option>
                    </select>
                </div>
            </div>
            <button type="button" class="btn btn-secondary w-100 mt-3" id="add-location">Ajouter une localisation</button>    
        </form>
    </div>
</div>
<script src="js/newVendeur.js" defer> </script>
<script src="js/codePostal.js" defer></script>




                