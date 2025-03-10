<div class="container">
    <h4>Gestion clients</h4>
    <div class="row d-flex align-items-start">
        <?php foreach ($clientsByStatut as $statut => $data) : ?>
            <?php if (!empty($data['clients'])) : // On n'affiche que les statuts ayant des clients ?>
                <div class="col-md-2">
                    <article class="mt-3 clients">
                        <p class="ms-3 mt-2 fs-5">
                        <?php 
                            // Inverser le tableau pour retrouver le texte lisible à partir de la valeur stockée
                            $niveauMappingInverse = array_flip($statutMapping);

                            // Vérifier si $niveau existe dans le tableau inversé, sinon formater par défaut
                            echo $niveauMappingInverse[$statut] ?? ucwords(str_replace('_', ' ', $statut));
                        ?>
                        </p>
                        <ul class="ms-3 mt-2 list-unstyled">
                            <li>Nombre de crèches: <strong><?= $data['nbCreches']; ?></strong></li>
                            <li>PNY potentiel: <strong><?= number_format($data['totalCommission'], 2, ',', ' '); ?> €</strong></li>
                        </ul>
                        <div class="ms-3">
                            <button id="boutonListe-<?= htmlspecialchars($statut); ?>" class="btn-liste btn btn-primary">Liste</button>
                        </div>
                    </article>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class = "row"> 
        <div class="articles col-md-6 mt-5">
            <h5 class = "mt-5">Rechercher un client</h5>
            <form class = "article" id="formResearchClient" method="POST" action="index.php?action=researchResultClient">
                <div class="row">
                    <div class="radio-group col-md-12">
                        <div class="radio-item">
                            <input type="radio" id="contact" name="clientResearch" value="contact" checked>
                            <label for="contact">contact</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="nom" name="clientResearch" value="nom">
                            <label for="nom">Nom du groupe</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="siren" name="clientResearch" value="siren">
                            <label for="siren">Siren</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="email" name="clientResearch" value="email">
                            <label for="email">Email</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="telephone" name="clientResearch" value="telephone">
                            <label for="telephone">Telephone</label>
                        </div>
                    </div>
                </div>    
                <div class="row mt-2 align-items-end">
                    <div class="col-md-8">
                        <div class="form-group" id="inputContact">
                            <label for="donneeclient">Contact</label>
                            <input type="text" class="form-control client-input" name="donneeContact" id="donneeContact" list="getContacts">
                            <datalist id="getContacts">
                            <?php foreach ($clients as $client) : ?>
                                <option value="<?php echo htmlspecialchars($client->getContact()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputNomGroupe">
                            <label for="donneeNomGroupe">Nom du groupe</label>
                            <input type="text" class="form-control client-input" name="donneeNomGroupe" id="donneeNomGroupe" list="getNoms">
                            <datalist id="getNoms">
                            <?php foreach ($clients as $client) : ?>
                                <option value="<?php echo htmlspecialchars($client->getNom()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputSIREN">
                            <label for="donneeSIREN">SIREN</label>
                            <input type="text" class="form-control client-input" name="donneeSIREN" id="donneeSIREN" list="getSirens">
                            <datalist id="getSirens">
                            <?php foreach ($clients as $client) : ?>
                                <option value="<?php echo htmlspecialchars($client->getSiren()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputEmail">
                            <label for="donneeEmail">Email</label>
                            <input type="email" class="form-control client-input" name="donneeEmail" id="donneeEmail" list="getEmails">
                            <datalist id="getEmails">
                            <?php foreach ($clients as $client) : ?>
                                <option value="<?php echo htmlspecialchars($client->getEmail()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputTelephone">
                            <label for="donneeTelephone">Téléphone</label>
                            <input type="tel" class="form-control client-input" name="donneeTelephone" id="donneeTelephone" list="getTelephones">
                            <datalist id="getTelephones">
                            <?php foreach ($clients as $client) : ?>
                                <option value="<?php echo htmlspecialchars($client->getTelephone()); ?>"></option>
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
        <div class = "articles col-md-6 mt-5">
            <h5 class = "mt-5">Rechercher des crèches à vendre</h5>
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
                        <div class="radio-item">
                            <input type="radio" id="researchFrance" name="localResearch" value="researchFrance">
                            <label for="researchFrance">France</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 align-items-end">
                    <div class="row form-row col-md-8">
                        <div class="row form-row col-md-12" id ="inputVille">
                            <div class="form-group col-md-9 ">
                                <label for="zoneVille">Ville</label>
                                <input type="text" class="form-control vente-input" name="zoneVille" id="zoneVille" list="getZoneVilles">
                                <datalist id="getZoneVilles">
                                <?php foreach ($villes as $ville) : ?>
                                    <option value="<?php echo htmlspecialchars($ville->getVille()); ?>"></option>
                                <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="form-group col-md-3" id ="inputVilleRayon">
                                <label for="zoneVilleRayon">Rayon</label>
                                <input class="form-control vente-input" type="number" name="zoneVilleRayon" id="zoneVilleRayon" min="0" step="5">
                            </div>
                        </div>
                        <div class="form-group d-none" id ="inputDepartement">
                            <label for="zoneDepartement">Département</label>
                            <input type="text" class="form-control vente-input" name="zoneDepartement" id="zoneDepartement" list="getZoneDepartements">
                            <datalist id="getZoneDepartements">
                            <?php foreach ($departements as $departement) : ?>
                                <option value="<?php echo htmlspecialchars($departement->getDepartement()); ?>"></option>
                            <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id = "inputRegion">
                            <label for="zoneRegion">Région</label>
                            <input type="text" class="form-control vente-input" name="zoneRegion" id="zoneRegion" list="getZoneRegions">
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
        </div>
    </div>
    <div class="row">
        <h5>Rechercher les intérêts</h5>
        <div class = "articles col-md-6 mt-5">
            <form class = "article" id="formResearchIdentifiant" method="POST" action="index.php?action=researchResultInteretCreche">
                <div class="row form-row mt-3 align-items-end">
                    <div class="form-group col-md-8">
                        <label for="identifiant">Sur une crèche</label>
                        <input type="text" class="form-control" name="identifiant" id="identifiant" list="getIdentifiants">
                        <datalist id="getIdentifiants">
                        <?php foreach ($identifiants as $identifiant) : ?>
                            <option value="<?php echo htmlspecialchars($identifiant); ?>"></option>
                        <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="form-group col-md-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary small-button align-self-end">Chercher</button>
                    </div>
                </div>
            </form>
        </div>
        <div class = "articles col-md-6 mt-5">
            <form class = "article" id="formResearchGroupe" method="POST" action="index.php?action=researchResultInteretGroupe">
                <div class="row form-row mt-2 align-items-end">
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
    </div>
</div>
<script src="js/clients.js" defer> </script>

