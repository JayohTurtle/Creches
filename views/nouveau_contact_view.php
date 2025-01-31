
<?php

require_once(__DIR__ . '/head.php'); 
 
?>

<body>
    <?php require_once(__DIR__ . '/header.php'); ?>
    <div class="container">
        <div class="container form-container mt-5">
            <form id="form" method="post" action="nouveau_contact.php">
                <h5 class="mt-3">Identité</h5>
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
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                        <small class="form-text">Message d'erreur</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="telephone">Téléphone</label>
                        <input type="text" class="form-control" name="telephone" id="telephone">
                        <small class="form-text">Message d'erreur</small>
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
                <div class="row form-row mt-3" id="adresse">
                    <div class="form-group col-md-3">
                        <label for="ville">Ville</label>
                        <input class="form-control" list="villes" id="ville" name="ville">
                        <datalist id="villes">
                            <?php
                                include(__DIR__ . '/options_villes.php');
                            ?>
                        </datalist>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="postalCode">Code postal</label>
                        <input class="form-control" id="postalCode" name="postalCode">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="departement">Département</label>
                        <input class="form-control" list="departements" id="departement" name="departement">
                        <datalist id="departements">
                            <?php
                                include(__DIR__ . '/options_departements.php');
                            ?>
                        </datalist>
                    </div>
                    <div class="form-group col-md-2 d-none" id="seller-choice">
                        <label for="statut">Statut</label>
                        <select class="form-control" name="statut" id="statut">
                            <option value="approche">Approche</option>
                            <option value="nego">Négociation</option>
                            <option value="mandatEnvoye">Mandat envoyé</option>
                            <option value="mandatSigne">Mandat signé</option>
                            <option value="vendu">Vendu</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary mt-3" id="add-location">Ajouter une localisation</button>    
                </div>
                <h5 class="mt-3" id="buyer-title">Intérêt</h5>
                <div class="form-group col-md-4">
                    <div class="row">
                        <p>Taille</p>
                        <div class="radio-group">
                            <div class="radio-item">
                                <input type="radio" id="microCreche" name="sizeCreche" value="microCreche">
                                <label for="microCreche">Micro-crèche</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="creche" name="sizeCreche" value="Creche">
                                <label for="creche">Creche</label>
                            </div>
                            <div class="radio-item">
                                <input type="radio" id="bothCreche" name="sizeCreche" value="bothCreche">
                                <label for="microCreche">Les 2</label>
                            </div>
                        </div>
                    </div>
                </div>      
                <div id="interest">
                    <div class="row form-row mt-3" >
                        <div class="form-group col-md-2">
                            <label for="niveau">Niveau</label>
                            <select class="form-control" name="niveau" id="niveau">
                                <option value= null></option>
                                <option value="interesse">Intéressé</option>
                                <option value="NDAenvoye">NDA envoyé</option>
                                <option value="dossierEnvoye">Dossier envoyé</option>
                                <option value="LOI">LOI</option>
                                <option value="achat">Achat réalisé</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="villeInterest">Ville</label>
                            <input class="form-control" list="villesInterest" id="villeInterest" name="villeInterest">
                            <datalist id="villesInterest">
                                <?php
                                    include(__DIR__ . '/options_villes.php');
                                ?>
                            </datalist>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="postalCodeInterest">Code postal</label>
                            <input class="form-control" id="postalCodeInterest" name="postalCodeInterest">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="rayonInterest">Rayon</label>
                            <input class="form-control" id="rayonInterest" name="rayonInterest">
                        </div>
                    </div>
                    <div class="row form-row mt-3" >
                        <div class="form-group col-md-3">
                            <label for="departementInterest">Département</label>
                            <input class="form-control" list="departementsInterest" id="departementInterest" name="departementInterest">
                            <datalist id="departementsInterest">
                                <?php
                                    include(__DIR__ . '/options_departements.php');
                                ?>
                            </datalist>
                        </div>    
                        <div class="form-group col-md-3">
                            <label for="identifierInterest">Identifiant</label>
                            <input class="form-control" list="identifiersInterest" id="identifierInterest" name="identifierInterest">
                            <datalist id="identifierInterest">
                                <option value= null>
                                <option value="Consultation">
                            </datalist>
                        </div>    
                        <button type="button" class="btn btn-secondary mt-3" id="add-interest">Ajouter un intérêt</button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
            </form>
        </div>
    </div>
    <script src="js/form_contact.js" defer> </script>
</body>
</html>