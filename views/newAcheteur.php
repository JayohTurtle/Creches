<div class="container form-container mt-1">
    <?php if ($success = true) : ?>
        <div  id="success-message">
            ✅ Contact ajouté !
        </div>
    <?php endif; ?>
</div>
<div class="container form-container mt-1">
    <form id="formAcheteur" method="POST" action="index.php?action=ajoutAcheteur">
        <h5 class="mt-3">Localisation de/des crèches</h5>
        <div class="row form-row mt-3 align-items-center" id="location">
            <div class="form-group col-md-2">
                <label for="ville">Ville</label>
                <input class="form-control" list="villes" id="ville" name="ville[]" autocomplete="off">
                <datalist id="villes"></datalist>
            </div>
            <div class="form-group col-md-1">
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
            <input type="hidden" name="idContact" value="<?= $idContact; ?>">
            <input type="hidden" name="nom" value="<?= $nom; ?>">
            <div class="col-md-3 d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary w-100 mt-3" id="add-location">Ajouter une localisation</button>    
        <h5 class="mt-3" id="buyer-title">Intérêt</h5>
        <div class="row form-row mt-3 align-items-center" id = "interest">
            <div class="form-group col-md-6">
                <h6>Intérêt général</h6>
                <div class="row form-row align-items-end" id="villeInterestDiv">
                    <div class="form-group col-md-4">
                        <label for="villeInterest">Ville</label>
                        <input class="form-control" list="villesInterest" id="villeInterest" name="villeInterest[]" autocomplete="off">
                        <datalist id="villesInterest"></datalist>
                        </datalist>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="codePostalInterest">Code postal</label>
                        <input class="form-control" type="text" id="codePostalInterest" list="codePostauxInterest" name="codePostalInterest[]" autocomplete="off">
                        <datalist id="codePostauxInterest"></datalist>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="rayonInterest">Rayon</label>
                        <input class="form-control" id="rayonInterest" name="rayonInterest[]">
                    </div>
                    <div class="form-group col-md-1 d-flex justify-content-end">
                        <i class="fas fa-plus-circle text-secondary" style="font-size: 1.5rem; cursor: pointer;" id="add-interestVille"></i>
                    </div>
                </div>
                <div class="row form-row align-items-end" id="departementInterestDiv">
                    <div class="form-group col-md-7">
                    <label for="departementInterest">Département</label>
                    <input class="form-control" list="departementsInterest" id="departementInterest" name="departementInterest[]">
                    <datalist id="departementsInterest">
                        <?php 
                            foreach ($departements as $departement) : ?>
                                <option value="<?= htmlspecialchars($departement -> getDepartement()); ?>"></option>
                            <?php endforeach; 
                        ?>
                    </datalist>
                    </div>
                    <div class="form-group col-md-1 d-flex justify-content-end">
                        <i class="fas fa-plus-circle text-secondary" style="font-size: 1.5rem; cursor: pointer;" id="add-interestDepartement"></i>
                    </div>
                </div>
                <div class="row form-row align-items-end" id="regionInterestDiv">
                    <div class="form-group col-md-7">
                    <label for="regionInterest">Région</label>
                    <input class="form-control" list="regionsInterest" id="regionInterest" name="regionInterest[]">
                    <datalist id="regionsInterest">
                        <?php 
                            foreach ($regions as $region) : ?>
                                <option value="<?= htmlspecialchars($region -> getRegion()); ?>"></option>
                            <?php endforeach; 
                        ?>
                    </datalist>
                    </div>
                    <div class="form-group col-md-1 d-flex justify-content-end">
                        <i class="fas fa-plus-circle text-secondary" style="font-size: 1.5rem; cursor: pointer;" id="add-interestRegion"></i>
                    </div>
                </div>
                <div>
                    <label for="franceInterest">Toute la France</label>
                    <input type="checkbox" id="franceInterest" name="franceInterest" value="franceInterest">
                </div>
            </div>
            <div class="form-group col-md-6" id="crecheGroupChoice">
                <h6 class = "mt-3">Intérêt précis</h6>
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
                <div class="row form-row mt-3">
                    <div class="form-group col-md-3">
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
                    <div class="form-group col-md-7" id="inputChoixCreche">
                        <label for="identifiantInterest">Nom de la crèche</label>
                        <input class="form-control" list="getIdentifiantInterests" id="identifiantInterest" name="identifiantInterest" autocomplete="off">
                        <datalist id="getIdentifiantInterests">
                        <?php foreach ($localisations as $localisation) : ?>
                            <?php foreach (explode(', ', $localisation->getIdentifiant()) as $identifiant) : ?>
                                <?php if (!empty($identifiant)) : ?>
                                    <option value="<?= htmlspecialchars($identifiant); ?>"></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="form-group col-md-7 d-none" id="inputChoixGroup">
                        <label for="groupeInterests">Nom du groupe</label>
                        <input class="form-control" list="getGroupeInterests" id="groupeInterest" name="groupeInterest" autocomplete="off">
                        <datalist id="getGroupeInterests">
                        <?php foreach ($groupes as $groupe) : ?>
                            <?php foreach (explode(', ', $groupe->getnom()) as $nom) : ?>
                                <?php if (!empty($nom)) : ?>
                                    <option value="<?= htmlspecialchars($nom); ?>"></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        </datalist>
                    </div>
                </div>
                <div class="form-group col-md-8" id="crecheSizeChoice">
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
            </div>
        </div>
    </form>
</div>
<script src="js/newAcheteur.js" defer></script>
<script src="js/codePostal.js" defer></script>
<script src="js/validate_form_acheteur.js" defer></script>


