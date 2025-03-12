<div class="container">
    <h4>Gestion acheteurs</h4>
    <div class="row d-flex align-items-start">
        <?php foreach ($groupes as $niveau => $data) : ?>
            <div class="col-md-2">
                <article class="mt-3 clients">
                    <p class="ms-3 mt-2 fs-5">
                    <?php 
                        // Inverser le tableau pour retrouver le texte lisible à partir de la valeur stockée
                        $niveauMappingInverse = array_flip($niveauMapping);

                        // Vérifier si $niveau existe dans le tableau inversé, sinon formater par défaut
                        echo $niveauMappingInverse[$niveau] ?? ucwords(str_replace('_', ' ', $niveau));
                    ?>
                    </p>
                    <ul class="ms-3 mt-2 list-unstyled">
                        <li>Acheteurs : <strong><?= $data['acheteurs']; ?></strong></li>
                        <li>Crèches : <?= $data['creches']; ?> crèches</li>
                    </ul>
                    <div class="ms-3">
                        <button id="boutonListe-<?= htmlspecialchars($niveau); ?>" class="btn-liste btn btn-primary">
                            Liste
                        </button>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
    <div class = "row mt-5"> 
        <div class="articles col-md-6 mt-5">
            <h5 class = "mt-5">Rechercher un acheteur</h5>
            <form class = "article" id="formResearchContact" method="POST" action="index.php?action=resultAcheteur">
                <div class="row">
                    <div class="radio-group col-md-12">
                        <div class="radio-item">
                            <input type="radio" id="contact" name="contactResearch" value="contact" checked>
                            <label for="contact">Contact</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="nom" name="contactResearch" value="nom">
                            <label for="nom">Nom du groupe</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="siren" name="contactResearch" value="siren">
                            <label for="siren">Siren</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="email" name="contactResearch" value="email">
                            <label for="email">Email</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="telephone" name="contactResearch" value="telephone">
                            <label for="telephone">Telephone</label>
                        </div>
                    </div>
                </div>    
                <div class="row mt-2 align-items-end">
                    <div class="col-md-8">
                        <div class="form-group" id="inputContact">
                            <label for="donneeContact">Contact</label>
                            <input type="text" class="form-control contact-input" name="donneeContact" id="donneeContact" list="getContacts">
                            <datalist id="getContacts">
                            <?php foreach ($contacts as $contact) : ?>
                                <option value="<?= htmlspecialchars($contact->getContact()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputNomGroupe">
                            <label for="donneeNomGroupe">Nom du groupe</label>
                            <input type="text" class="form-control contact-input" name="donneeNomGroupe" id="donneeNomGroupe" list="getNoms">
                            <datalist id="getNoms">
                            <?php foreach ($contacts as $contact) : ?>
                                <option value="<?= htmlspecialchars($contact->getNom()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputSIREN">
                            <label for="donneeSIREN">SIREN</label>
                            <input type="text" class="form-control contact-input" name="donneeSIREN" id="donneeSIREN" list="getSirens">
                            <datalist id="getSirens">
                            <?php foreach ($contacts as $contact) : ?>
                                <option value="<?= htmlspecialchars($contact->getSiren()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputEmail">
                            <label for="donneeEmail">Email</label>
                            <input type="email" class="form-control contact-input" name="donneeEmail" id="donneeEmail" list="getEmails">
                            <datalist id="getEmails">
                            <?php foreach ($contacts as $contact) : ?>
                                <option value="<?= htmlspecialchars($contact->getEmail()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputTelephone">
                            <label for="donneeTelephone">Téléphone</label>
                            <input type="tel" class="form-control contact-input" name="donneeTelephone" id="donneeTelephone" list="getTelephones">
                            <datalist id="getTelephones">
                            <?php foreach ($contacts as $contact) : ?>
                                <option value="<?= htmlspecialchars($contact->getTelephone()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="form-group col-md-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary small-button align-self-end">Chercher</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="articles col-md-6 mt-5">
            <h5 class="mt-5">Rechercher des acheteurs par zone</h5>
            <form class="article" id="formResearchZoneAchat" method="POST" action="index.php?action=resultZoneAchat">
                <div class="row">
                    <div class="radio-group col-md-12">
                        <div class="radio-item">
                            <input type="radio" id="researchVilleAchat" name="localResearchAchat" value="researchVilleAchat" checked>
                            <label for="researchVilleAchat">Ville</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="researchDepartementAchat" name="localResearchAchat" value="researchDepartementAchat">
                            <label for="researchDepartementAchat">Departement</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="researchRegionAchat" name="localResearchAchat" value="researchRegionAchat">
                            <label for="researchRegionAchat">Région</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="researchFranceAchat" name="localResearchAchat" value="researchFranceAchat">
                            <label for="researchFranceAchat">France</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 align-items-end">
                    <div class="col-md-8">
                        <div class="row form-row col-md-12" id ="inputVilleAchat">
                            <div class="form-group col-md-9 ">
                                <label for="zoneVilleAchat">Ville</label>
                                <input type="text" class="form-control achat-input" name="zoneVilleAchat" id="zoneVilleAchat" list="getZoneVillesAchat">
                                <datalist id="getZoneVillesAchat">
                                <?php foreach ($villes as $ville) : ?>
                                    <option value="<?php echo htmlspecialchars($ville->getVille()); ?>"></option>
                                <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="form-group col-md-3" id ="inputVilleRayonAchat">
                                <label for="zoneVilleRayonAchat">Rayon</label>
                                <input class="form-control achat-input" type="number" name="zoneVilleRayonAchat" id="zoneVilleRayonAchat" min="0" step="5">
                            </div>
                        </div>
                        <div class="form-group d-none" id ="inputDepartementAchat">
                            <label for="zoneDepartementAchat">Département</label>
                            <input type="text" class="form-control achat-input" name="zoneDepartementAchat" id="zoneDepartementAchat" list="getZoneDepartementsAchat">
                            <datalist id="getZoneDepartementsAchat">
                            <?php foreach ($departements as $departement) : ?>
                                <option value="<?php echo htmlspecialchars($departement->getDepartement()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id = "inputRegionAchat">
                            <label for="zoneRegionAchat">Région</label>
                            <input type="text" class="form-control achat-input" name="zoneRegionAchat" id="zoneRegionAchat" list="getZoneRegionsAchat">
                            <datalist id="getZoneRegionsAchat">
                            <?php foreach ($regions as $region) : ?>
                                <option value="<?php echo htmlspecialchars($region->getRegion()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="row form-row mt-3 align-items-end">
                        <div class="form-group col-md-2">
                            <label for="researchNbreCreche">Nombre de crèches</label>
                            <input type="number" class="form-control" name="researchNbreCreche" id="researchNbreCreche">
                        </div>
                        <div class="form-group col-md-7 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary small-button align-self-end">Chercher</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/acheteurs.js" defer> </script>
<script src="js/validate_form_contacts.js" defer> </script>