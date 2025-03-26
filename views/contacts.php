<div class="container">
<h4>Rechercher un contact</h4>
    <div class = "row mt-5"> 
        <div class="articles col-md-6">
        <h5>Recherche par données</h5>
            <form class = "article" id="formResearchContact" method="POST" action="index.php?action=researchContacts">
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
                            <input type="text" class="form-control contact-input" name="donneeContact" id="donneeContact" list="getContacts" autocomplete="off">
                            <datalist id="getContacts">
                            <?php foreach ($contacts as $contact) : ?>
                                <option value="<?= htmlspecialchars($contact->getContact()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputNomGroupe">
                            <label for="donneeNomGroupe">Nom du groupe</label>
                            <input type="text" class="form-control contact-input" name="donneeNomGroupe" id="donneeNomGroupe" list="getNoms" autocomplete="off">
                            <datalist id="getNoms">
                            <?php foreach ($contacts as $contact) : ?>
                                <option value="<?= htmlspecialchars($contact->getNom()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputSIREN">
                            <label for="donneeSIREN">SIREN</label>
                            <input type="text" class="form-control contact-input" name="donneeSIREN" id="donneeSIREN" list="getSirens" autocomplete="off">
                            <datalist id="getSirens">
                            <?php foreach ($contacts as $contact) : ?>
                                <option value="<?= htmlspecialchars($contact->getSiren()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputEmail">
                            <label for="donneeEmail">Email</label>
                            <input type="email" class="form-control contact-input" name="donneeEmail" id="donneeEmail" list="getEmails" autocomplete="off">
                            <datalist id="getEmails">
                            <?php foreach ($contacts as $contact) : ?>
                                <option value="<?= htmlspecialchars($contact->getEmail()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputTelephone">
                            <label for="donneeTelephone">Téléphone</label>
                            <input type="tel" class="form-control contact-input" name="donneeTelephone" id="donneeTelephone" list="getTelephones" autocomplete="off">
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
        <div class="articles col-md-6">
            <h5>Recherche par zone</h5>
            <form class="article" id="formResearchZone" method="POST" action="index.php?action=resultZoneContact">
                <div class="row">
                    <div class="radio-group col-md-12">
                        <div class="radio-item">
                            <input type="radio" id="researchVille" name="localResearch" value="researchVille" checked>
                            <label for="researchVille">Ville</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="researchDepartement" name="localResearch" value="researchDepartement">
                            <label for="researchDepartement">Departement</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="researchRegion" name="localResearch" value="researchRegion">
                            <label for="researchRegion">Région</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="researchFrance" name="localResearch" value="researchFrance">
                            <label for="researchFrance">France</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 align-items-end">
                    <div class="col-md-8">
                        <div class="row form-row col-md-12" id ="inputVille">
                            <div class="form-group col-md-9 ">
                                <label for="zoneVille">Ville</label>
                                <input type="text" class="form-control -input" name="zoneVille" id="zoneVille" list="getZoneVilles" autocomplete="off">
                                <datalist id="getZoneVilles">
                                <?php foreach ($villes as $ville) : ?>
                                    <option value="<?php echo htmlspecialchars($ville->getVille()); ?>"></option>
                                <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="form-group col-md-3" id ="inputVilleRayon">
                                <label for="zoneVilleRayon">Rayon</label>
                                <input class="form-control -input" type="number" name="zoneVilleRayon" id="zoneVilleRayon" min="0" step="5">
                            </div>
                        </div>
                        <div class="form-group d-none" id ="inputDepartement">
                            <label for="zoneDepartement">Département</label>
                            <input type="text" class="form-control -input" name="zoneDepartement" id="zoneDepartement" list="getZoneDepartements" autocomplete="off">
                            <datalist id="getZoneDepartements">
                            <?php foreach ($departements as $departement) : ?>
                                <option value="<?php echo htmlspecialchars($departement->getDepartement()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id = "inputRegion">
                            <label for="zoneRegion">Région</label>
                            <input type="text" class="form-control -input" name="zoneRegion" id="zoneRegion" list="getZoneRegions" autocomplete="off">
                            <datalist id="getZoneRegions">
                            <?php foreach ($regions as $region) : ?>
                                <option value="<?php echo htmlspecialchars($region->getRegion()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="form-group col-md-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary small-button align-self-end">Chercher</button>
                    </div>
                    <div class="row form-row mt-3 align-items-end">
                        <div class="form-group col-md-2">
                            <label for="researchNbreCreche">Nombre de crèches</label>
                            <input type="number" class="form-control" name="researchNbreCreche" id="researchNbreCreche">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/contacts.js" defer> </script>