

<div class="container">
<?php if (!empty($success)) : ?>
    <div id = "success-message">
        ✅ Données ajoutées !
    </div>
<?php endif; ?>
    <div class="container form-container mt-1">
        <form id="form" method="POST" action="index.php?action=saveContact" novalidate>
            <h5 class="mt-2">Identité</h5>
            <div class="row form-row mt-3">
                <div class="form-group col-md-4">
                    <label for="contact">Contact</label>
                    <input type="text" class="form-control" name="contact" id="contact">
                </div>
                <div class="form-group col-md-5">
                    <label for="nom">Nom du groupe</label>
                    <input type="text" class="form-control" name="nom" id="nom">
                </div>
                <div class="form-group col-md-3">
                    <label for="siren">SIREN</label>
                    <input type="text" class="form-control" name="siren" id="siren">
                </div>
            </div>
            <div class="row form-row mt-3">
                <div class="form-group col-md-4">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email">
                </div>
                <div class="form-group col-md-4">
                    <label for="telephone">Téléphone</label>
                    <input type="text" class="form-control" name="telephone" id="telephone">
                </div>
                <div class="form-group col-md-4">
                    <label for="site">Site internet</label>
                    <input type="text" class="form-control" name="site" id="site">
                </div>
            </div>
            <div class="row form-row mt-3">    
                <div class="form-group col-md-3">
                    <p>Sens</p>
                    <input type="radio" id="buyer" name="directionChoice" value="Acheteur" checked>
                    <label for="buyer">Acheteur</label><br>
                    <input type="radio" id="seller" name="directionChoice" value="Vendeur">
                    <label for="seller">Vendeur</label><br>
                </div>
                <div class="form-group col-md-9">
                    <label for="comment">Commentaire</label>
                    <textarea name="comment" id="comment" rows="2" class="form-control"></textarea>
                </div>
            </div>
            <h5 class="mt-3">Localisation de/des crèches</h5>
            <div class="row form-row">
                <div class="form-group col-md-2 d-none" id="statutVendeur">
                    <label for="statut">Statut</label>
                    <select class="form-control" name="statut" id="statut">
                        <option value="Approche">Approche</option>
                        <option value="Négociation">Négociation</option>
                        <option value="Mandat envoyé">Mandat envoyé</option>
                        <option value="Mandat signé">Mandat signé</option>
                        <option value="Vendu">Vendu</option>
                    </select>
                </div>
                <div class="form-group col-md-3 d-none" id ="valoVendeur">
                    <label for="valorisation">Valorisation</label>
                    <input class="form-control" id="valorisation" name="valorisation">
                </div>
                <div class="form-group col-md-3 d-none" id="commVendeur">
                    <label for="commission">Commission</label>
                    <input class="form-control" id="commission" name="commission">
                </div>
            </div>
            <div class="row form-row mt-3" id="location">
                <div class="form-group col-md-3">
                    <label for="ville">Ville</label>
                    <input class="form-control" list="villes" id="ville" name="ville[]" autocomplete="off">
                    <datalist id="villes"></datalist>
                </div>
                <div class="form-group col-md-2">
                    <label for="codePostal">Code postal</label>
                    <input class="form-control" type="text" id="codePostal" list="codePostaux" name="codePostal[]" autocomplete="off">
                    <datalist id="codePostaux"></datalist>
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
            <h5 class="mt-3" id="buyer-title">Intérêt</h5>
            <div class="form-group col-md-4" id="crecheSizeChoice">
                <div class="row">
                    <p>Taille</p>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="microCreche" name="sizeCreche" value="Micro-crèche">
                            <label for="microCreche">Micro-crèche</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="creche" name="sizeCreche" value="Crèche">
                            <label for="creche">Crèche</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="bothCreche" name="sizeCreche" value="Les deux" checked>
                            <label for="bothCreche">Crèche et micro-crèche</label>
                        </div>
                    </div>
                </div>
            </div>
            <div id = "interest">
                <h6>Intérêt général</h6>
                <div class="row form-row align-items-end" id="villeInterestDiv">
                    <div class="form-group col-md-2">
                        <label for="villeInterest">Ville</label>
                        <input class="form-control" list="villesInterest" id="villeInterest" name="villeInterest[]">
                        <datalist id="villesInterest">
                            <?php 
                                foreach ($villes as $ville) : ?>
                                    <option value="<?php echo htmlspecialchars($ville->getVille()); ?>"></option>
                                <?php endforeach; 
                            ?>
                        </datalist>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="codePostalInterest">Code postal</label>
                        <input class="form-control" id="codePostalInterest" name="codePostalInterest[]">
                    </div>
                    <div class="form-group col-md-1">
                        <label for="rayonInterest">Rayon</label>
                        <input class="form-control" id="rayonInterest" name="rayonInterest[]">
                    </div>
                    <div class="form-group col-md-1 d-flex justify-content-end">
                        <i class="fas fa-plus-circle text-secondary" style="font-size: 1.5rem; cursor: pointer;" id="add-interestVille"></i>
                    </div>
                </div>
                <div class="row form-row align-items-end" id="departementInterestDiv">
                    <div class="form-group col-md-3">
                    <label for="departementInterest">Département</label>
                    <input class="form-control" list="departementsInterest" id="departementInterest" name="departementInterest[]">
                    <datalist id="departementsInterest">
                        <?php 
                            foreach ($departements as $departement) : ?>
                                <option value="<?php echo htmlspecialchars($departement -> getDepartement()); ?>"></option>
                            <?php endforeach; 
                        ?>
                    </datalist>
                    </div>
                    <div class="form-group col-md-1 d-flex justify-content-end">
                        <i class="fas fa-plus-circle text-secondary" style="font-size: 1.5rem; cursor: pointer;" id="add-interestDepartement"></i>
                    </div>
                </div>
                <div class="row form-row align-items-end" id="regionInterestDiv">
                    <div class="form-group col-md-3">
                    <label for="regionInterest">Région</label>
                    <input class="form-control" list="regionsInterest" id="regionInterest" name="regionInterest[]">
                    <datalist id="regionsInterest">
                        <?php 
                            foreach ($regions as $region) : ?>
                                <option value="<?php echo htmlspecialchars($region -> getRegion()); ?>"></option>
                            <?php endforeach; 
                        ?>
                    </datalist>
                    </div>
                    <div class="form-group col-md-1 d-flex justify-content-end">
                        <i class="fas fa-plus-circle text-secondary" style="font-size: 1.5rem; cursor: pointer;" id="add-interestRegion"></i>
                    </div>
                    <div>
                        <label for="franceInterest">Toute la France</label>
                        <input type="checkbox" id="franceInterest" name="franceInterest" value="franceInterest">
                    </div>
                </div>
                <h6 class = "mt-3">Intérêt précis</h6>
                <div class="form-group col-md-4" id="crecheGroupChoice">
                    <div class="row">
                        <p>Choix</p>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" id="choixCreche" name="crecheGroup" value="Creche" checked>
                                <label for="choixCreche">Crèche</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="choixGroup" name="crecheGroup" value="Groupe">
                                <label for="choixGroup">Groupe</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row form-row mt-3">
                    <div class="form-group col-md-2">
                        <label for="niveau">Niveau</label>
                        <select class="form-control" name="niveau" id="niveau">
                            <option value=""></option>
                            <option value="Intéressé">Intéressé</option>
                            <option value="NDA envoyé">NDA envoyé</option>
                            <option value="Dossier envoyé">Dossier envoyé</option>
                            <option value="LOI">LOI</option>
                            <option value="Achat réalisé">Achat réalisé</option>
                        </select>
                    </div>
                    <div class="form-group col-md-5" id="inputChoixCreche">
                        <label for="identifiantInterest">Nom de la crèche</label>
                        <input class="form-control" list="getIdentifiantInterests" id="identifiantInterest" name="identifiantInterest">
                        <datalist id="getIdentifiantInterests">
                        <?php foreach ($clients as $client) : ?>
                            <?php foreach (explode(', ', $client->getIdentifiant()) as $identifiant) : ?>
                                <?php if (!empty($identifiant)) : ?>
                                    <option value="<?php echo htmlspecialchars($identifiant); ?>"></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="form-group col-md-3 d-none" id="inputChoixGroup">
                        <label for="groupeInterests">Nom du groupe</label>
                        <input class="form-control" list="getGroupeInterests" id="groupeInterest" name="groupeInterest">
                        <datalist id="getGroupeInterests">
                        <?php foreach ($clients as $client) : ?>
                                <option value="<?php echo htmlspecialchars($client->getNom()); ?>"></option>
                            <?php endforeach; ?>
                        </datalist>
                    </div>   
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary" id="contactEnvoi">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<script src="js/codePostal.js" defer></script>
<script src="js/validate_form_contact.js" defer></script>
<script src="js/form_contact.js" defer> </script>
