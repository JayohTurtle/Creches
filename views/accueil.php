<?php
require __DIR__ . '/../includes/auth.php';// Vérifie si l'utilisateur est connecté

?>

<div class="container">
    <div class="row d-flex align-items-start">
        <article class="col-md-3">
            <?php if (isset($_SESSION['userEmail'])) {
                echo "<p>Utilisateur : " . htmlspecialchars($_SESSION['userEmail']) . "</p>";
                 if($_SESSION['userRole'] === "user"){
                    echo "<p>L'équipe de YouInvest tient à vous souhaiter une excellente journée pleine de réussites professionnelles Monsieur le Président Directeur Général</br>";
                }
                echo "<p>Statut: ". htmlspecialchars($_SESSION['userRole']) . "</p>";
            } else {
                echo "<p>Utilisateur non connecté.</p>";
            }

            ?>
            <p class="ms-2 mt-3 fs-5">Agenda</p>
            <div class="mt-2 ms-2 calendar"></div>
            <p class="ms-2 mt-3 fs-5">Mails</p>
            <div class="mt-2 ms-2 mailbox"></div>
            <div class="mt-5 ms-5">
                <button id="boutonRechercheContact" type="button" class="btn btn-primary" onclick="ouvrirPopup('popupRechercheContact')">Rechercher un contact</button>
            </div>
        </article>
        <article class="col-md-8 d-flex flex-column justify-content-center">
            <div id="map" style="height: 590px; width: 100%;"></div>
        </article>
    </div>
     <!-- Boîte modale pour rechercher un contact -->
     <div id="popupRechercheContact" class="modal" style="display: none;">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupRechercheContact')">&times;</span>
            <h3>Rechercher un contact</h3>
            <form class = "article" id="formResearchContact">
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
                                    <option value="<?php echo htmlspecialchars($contact->getContact()); ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputNomGroupe">
                            <label for="donneeNomGroupe">Nom du groupe</label>
                            <input type="text" class="form-control contact-input" name="donneeNomGroupe" id="donneeNomGroupe" list="getNoms">
                            <datalist id="getNoms">
                                <?php foreach ($contacts as $contact) : ?>
                                    <option value="<?php echo htmlspecialchars($contact->getNom()); ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputSIREN">
                            <label for="donneeSIREN">SIREN</label>
                            <input type="text" class="form-control contact-input" name="donneeSIREN" id="donneeSIREN" list="getSirens">
                            <datalist id="getSirens">
                                <?php foreach ($contacts as $contact) : ?>
                                    <option value="<?php echo htmlspecialchars($contact->getSiren()); ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputEmail">
                            <label for="donneeEmail">Email</label>
                            <input type="email" class="form-control contact-input" name="donneeEmail" id="donneeEmail" list="getEmails">
                            <datalist id="getEmails">
                                <?php foreach ($contacts as $contact) : ?>
                                    <option value="<?php echo htmlspecialchars($contact->getEmail()); ?>"></option>
                                <?php endforeach; ?>
                            </datalist>
                        </div>
                        <div class="form-group d-none" id="inputTelephone">
                            <label for="donneeTelephone">Téléphone</label>
                            <input type="tel" class="form-control contact-input" name="donneeTelephone" id="donneeTelephone" list="getTelephones">
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
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" defer></script>
<script src="js/map.js" defer></script>
<script src="js/contacts.js" defer></script>