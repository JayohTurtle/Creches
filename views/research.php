<div class="container">
    <div class = "row"> 
        <div class="articles col-md-6">
            <h5 class = "mt-3">Rechercher un contact</h5>
            <form class = "article" id="formResearchContact" method="POST" action="index.php?action=researchResultContact">
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
                            <input type="text" class="form-control" name="donneeContact" id="donneeContact" list="getContacts">
                            <datalist id="getContacts">
                                <?php foreach ($contacts as $contact) : ?>
                                    <option value="<?php echo htmlspecialchars($contact->getContact()); ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputNomGroupe">
                            <label for="donneeNomGroupe">Nom du groupe</label>
                            <input type="text" class="form-control" name="donneeNomGroupe" id="donneeNomGroupe" list="getNoms">
                            <datalist id="getNoms">
                                <?php foreach ($contacts as $contact) : ?>
                                    <option value="<?php echo htmlspecialchars($contact->getNom()); ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputSIREN">
                            <label for="donneeSIREN">SIREN</label>
                            <input type="text" class="form-control" name="donneeSIREN" id="donneeSIREN" list="getSirens">
                            <datalist id="getSirens">
                                <?php foreach ($contacts as $contact) : ?>
                                    <option value="<?php echo htmlspecialchars($contact->getSiren()); ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputEmail">
                            <label for="donneeEmail">Email</label>
                            <input type="text" class="form-control" name="donneeEmail" id="donneeEmail" list="getEmails">
                            <datalist id="getEmails">
                                <?php foreach ($contacts as $contact) : ?>
                                    <option value="<?php echo htmlspecialchars($contact->getEmail()); ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputTelephone">
                            <label for="donneeTelephone">Téléphone</label>
                            <input type="text" class="form-control" name="donneeTelephone" id="donneeTelephone" list="getTelephones">
                            <datalist id="getTelephones">
                                <?php foreach ($contacts as $contact) : ?>
                                    <option value="<?php echo htmlspecialchars($contact->getTelephone()); ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="form-group col-md-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary small-button align-self-end">Chercher</button>
                    </div>
                </div>
            </form>
            <h5>Rechercher les intérêts</h5>
            <form class = "article" id="formResearchIdentifiant" method="POST" action="index.php?action=researchResultInteretCreche">
                <div class="row form-row mt-3 align-items-end">
                    <div class="form-group col-md-8">
                        <label for="identifiant">Sur une crèche</label>
                        <input type="text" class="form-control" name="identifiant" id="identifiant" list="getIdentifiants">
                        <datalist id="getIdentifiants">
                        <?php foreach ($clients as $client) : ?>
                            <?php foreach (explode(', ', $client->getIdentifiant()) as $identifiant) : ?>
                                <?php if (!empty($identifiant)) : ?>
                                    <option value="<?php echo htmlspecialchars($identifiant); ?>"></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="form-group col-md-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary small-button align-self-end">Chercher</button>
                    </div>
                </div>
            </form>
            <form class = "article" id="formResearchGroupe" method="POST" action="index.php?action=researchResultInteretGroupe">
                <div class="row form-row mt-3 align-items-end">
                    <div class="form-group col-md-8">
                        <label for="groupe">Sur un groupe</label>
                        <input type="text" class="form-control" name="groupe" id="groupe" list="getGroupes">
                        <datalist id="getGroupes">
                            <?php foreach ($clients as $client) : ?>
                                <option value="<?php echo htmlspecialchars($client->getNom()); ?>"></option>
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="form-group col-md-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary small-button align-self-end">Chercher</button>
                    </div>
                </div>
            </form>
        </div>
        <div class = "articles col-md-6">
            <h5 class = "mt-3">Rechercher des crèches à vendre</h5>
            <form class = "article" id="formResearchVente" method="POST" action="index.php?action=researchResultZoneVente">
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
                    </div>
                </div>
                <div class="row mt-2 align-items-end">
                    <div class="row form-row col-md-8">
                        <div class="row form-row col-md-12" id ="inputVille">
                            <div class="form-group col-md-9 ">
                                <label for="zoneVille">Ville</label>
                                <input type="text" class="form-control" name="zoneVille" id="zoneVille" list="getZoneVilles">
                                <datalist id="getZoneVilles">
                                <?php foreach ($villes as $ville) : ?>
                                    <option value="<?php echo htmlspecialchars($ville->getVille()); ?>"></option>
                                <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="form-group col-md-3" id ="inputVilleRayon">
                                <label for="zoneVilleRayon">Rayon</label>
                                <input class="form-control" type="number" name="zoneVilleRayon" id="zoneVilleRayon" min="0" step="5">
                            </div>
                        </div>
                        <div class="form-group d-none" id ="inputDepartement">
                            <label for="zoneDepartement">Département</label>
                            <input type="text" class="form-control" name="zoneDepartement" id="zoneDepartement" list="getZoneDepartements">
                            <datalist id="getZoneDepartements">
                            <?php foreach ($departements as $departement) : ?>
                                <option value="<?php echo htmlspecialchars($departement->getDepartement()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id = "inputRegion">
                            <label for="zoneRegion">Région</label>
                            <input type="text" class="form-control" name="zoneRegion" id="zoneRegion" list="getZoneRegions">
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
                </div>
            </form>
            <h5>Rechercher des acheteurs par zone</h5>
            <form class="article" id="formResearchZoneAchat" method="POST" action="index.php?action=researchResultZoneAchat">
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
                    </div>
                </div>
                <div class="row mt-2 align-items-end">
                    <div class="col-md-8">
                        <div class="form-group" id ="inputVilleAchat">
                            <label for="zoneVilleAchat">Ville</label>
                            <input type="text" class="form-control" name="zoneVilleAchat" id="zoneVilleAchat" list="getZoneVillesAchat">
                            <datalist id="getZoneVillesAchat">
                            <?php foreach ($villes as $ville) : ?>
                                <option value="<?php echo htmlspecialchars($ville->getVille()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id ="inputDepartementAchat">
                            <label for="zoneDepartementAchat">Département</label>
                            <input type="text" class="form-control" name="zoneDepartementAchat" id="zoneDepartementAchat" list="getZoneDepartementsAchat">
                            <datalist id="getZoneDepartementsAchat">
                            <?php foreach ($departements as $departement) : ?>
                                <option value="<?php echo htmlspecialchars($departement->getDepartement()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id = "inputRegionAchat">
                            <label for="zoneRegionAchat">Région</label>
                            <input type="text" class="form-control" name="zoneRegionAchat" id="zoneRegionAchat" list="getZoneRegionsAchat">
                            <datalist id="getZoneRegionsAchat">
                            <?php foreach ($regions as $region) : ?>
                                <option value="<?php echo htmlspecialchars($region->getRegion()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                    </div>
                    <div class="row form-row mt-3 align-items-end">
                        <div class="form-group col-md-4">
                            <label for="researchNbreCreche">Nombre de crèches</label>
                            <input type="text" class="form-control" name="researchNbreCreche" id="researchNbreCreche">
                        </div>
                        <div class="form-group col-md-3 d-flex justify-content-end ms-4">
                            <button type="submit" class="btn btn-primary small-button align-self-end">Chercher</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/research.js" defer> </script>
<script src="js/validate_form_research.js" defer> </script>