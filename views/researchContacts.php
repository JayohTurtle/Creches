<div class="container">
    <div class="articles">
        <div class="row">
            <div class="article contact-article col-md-3">
                <h5>Identité</h5>
                <?php if (isset($contact) && $contact instanceof Contact): ?>
                    <!-- Affichage des informations du contact -->
                    <p><strong>Nom: </strong> <?= htmlspecialchars($contact->getNom()) ?></p>
                    <p><strong>Contact: </strong> <?= htmlspecialchars($contact->getContact()) ?></p>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <strong>Email: </strong>
                        <span id="emailACopier_<?= htmlspecialchars($contact->getEmail()) ?>"><?= htmlspecialchars($contact->getEmail()) ?></span>
                        <img class="iconCopie" src="assets/images/copier.png" alt="Copier" onclick="copierTextePopup('emailACopier_<?= htmlspecialchars($contact->getEmail()) ?>', this)">
                        <a href="#" onclick="ouvrirPopup('popupModifEmail')"><img class="iconCopie" src="assets/images/modif.png" alt="Modifier"></a>
                    </p>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <strong>Téléphone: </strong> <?= htmlspecialchars($contact->getTelephone()) ?>
                        <a href="#" onclick="ouvrirPopup('popupModifTelephone')"><img class="iconCopie" src="assets/images/modif.png" alt="Modifier"></a>
                    </p>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <strong>Sens: </strong> <?= htmlspecialchars($contact->getSens()) ?>
                        <a href="#" onclick="ouvrirPopup('popupModifSens')"><img class="iconCopie" src="assets/images/modif.png" alt="Modifier"></a>
                    </p>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <strong>Site Internet: </strong> 
                        <a href="<?= htmlspecialchars($contact->getSiteInternet()) ?>" target="_blank">
                            <?= htmlspecialchars($contact->getSiteInternet()) ?>
                        </a>
                        <a href="#" onclick="ouvrirPopup('popupModifSite')"><img class="iconCopie" src="assets/images/modif.png" alt="Modifier"></a>
                    </p>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <strong>SIREN: </strong>
                        <span id="sirenACopier_<?= htmlspecialchars($contact->getSiren()) ?>"><?= htmlspecialchars($contact->getSiren()) ?></span>
                        <img class="iconCopie" src="assets/images/copier.png" alt="Copier" onclick="copierTextePopup('sirenACopier_<?= htmlspecialchars($contact->getSiren()) ?>', this)">
                        <a href="#" onclick="ouvrirPopup('popupModifSIREN')"><img class="iconCopie" src="assets/images/modif.png" alt="Modifier"></a>
                    </p>
                    <?php if(htmlspecialchars($contact->getSens()) !== "Neutre"): ?>
                        <form method="POST" action="index.php?action=seeContact">
                            <input type="hidden" name="idContact" value="<?= htmlspecialchars($contact->getIdContact()) ?>">
                            <input type="hidden" name="sens" value="<?= htmlspecialchars($contact->getSens()) ?>">
                            <button type ="submit" class="btn btn-primary">Voir la fiche complète</button>
                        </form>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Aucun contact trouvé.</p>
                <?php endif; ?>
            </div>
            <div class="col-md-8">
                <div class="article col-md-12">
                    <h5>Commentaires</h5>
                    <?php if (!empty($commentaires)): ?>
                        <ul>
                            <?php foreach ($commentaires as $commentaire): ?>
                                <li>Le <?= htmlspecialchars($commentaire->getDateCommentFormatFr())?>, <?= htmlspecialchars($commentaire->getOperateur())?> a écrit : <?= htmlspecialchars($commentaire->getCommentaire())?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Aucun commentaire trouvé.</p>
                    <?php endif; ?>
                    <div class=" mb-3">
                        <i class="fas fa-plus-circle text-secondary" style="font-size: 1.5rem; cursor: pointer;" onclick="ouvrirPopup('popupAjoutComment')"></i>
                    </div>
                </div>
                <div class="article col-md-12 mt-2">
                    
                    <?php if (!empty($localisations)): ?>
                        <h5>Localisation des crèches</h5>
                        <ul>
                            <?php foreach ($localisations as $localisation): ?>
                                <li>
                                    <a href="index.php?action=creche&idLocalisation=<?= htmlspecialchars($localisation->getIdLocalisation())?>">
                                        Adresse : <?= htmlspecialchars($localisation->getAdresse()) ?>,
                                        <?= htmlspecialchars($localisation->getVille()->getVille()) ?>,
                                        <?= htmlspecialchars($localisation->getDepartement()->getDepartement()) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Aucune localisation trouvée.</p>
                    <?php endif; ?>
                    <div class=" mb-3">
                        <i class="fas fa-plus-circle text-secondary" style="font-size: 1.5rem; cursor: pointer;" onclick="ouvrirPopup('popupAjoutLocalisation')"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!-- Boîte modale pour modifier un email -->
     <div id="popupModifEmail" class="modal">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupModifEmail')">&times;</span>
            <h5>Ajouter/modifier un email</h5>
            <form class = "article justify-content-center infoContactForm" id="ajoutInfoEmail" method="POST">
                <div class="row mt-2 justify-content-center">
                    <div class="form-group w-100" id="inputInfoEmail">
                        <label for="infoEmail">Email</label>
                        <input type="email" class="form-control" name="valeur" id="infoEmail">
                    </div>
                    <?php if (isset($contact) && $contact instanceof Contact): ?>
                        <input type="hidden" name="champ" value="email">
                        <input type="hidden" name="idContact" value="<?= (int) $contact->getIdContact() ?>">
                    <?php endif; ?>
                </div>
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour modifier un téléphone -->
        <div id="popupModifTelephone" class="modal">
            <div class="modal-content form-group d-flex flex-column align-items-center">
                <span class="close" onclick="fermerPopup('popupModifTelephone')">&times;</span>
                <h5>Ajouter/modifier téléphone</h5>
                <form class = "article justify-content-center infoContactForm" id="addInfoContact" method="POST">
                    <div class="row mt-2 justify-content-center">
                        <div class="form-group w-100" id="inputInfoTelephone">
                            <label for="infoTelephone">Téléphone</label>
                            <input type="tel" class="form-control" name="valeur" id="infoTelephone">
                        </div>                        
                        <?php if (isset($contact) && $contact instanceof Contact): ?>
                            <input type="hidden" name="champ" value="telephone">
                            <input type="hidden" name="idContact" value="<?= (int) $contact->getIdContact() ?>">
                        <?php endif; ?>
                    </div>
                    <div class="form-group col-md-3 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary small-button">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Boîte modale pour modifier le sens -->
    <div id="popupModifSens" class="modal">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupModifSens')">&times;</span>
            <h5>Modifier le sens</h5>
            <form class = "article justify-content-center infoContactForm" id="addInfoSens" method="POST">
                <div class="row mt-2 justify-content-center">
                    <div class="form-group" id="inputInfoSens">
                        <label for="infoSens">Sens</label>
                        <select class="form-control w-100" name="valeur" id="infoSens">
                            <option value=""></option>
                            <option value="Acheteur">Acheteur</option>
                            <option value="Vendeur">Vendeur</option>
                            <option value="Acheteur/vendeur">Acheteur/Vendeur</option>
                            <option value="Neutre">Neutre</option>
                        </select>
                        <?php if (isset($contact) && $contact instanceof Contact): ?>
                            <input type="hidden" name="champ" value="sens">
                            <input type="hidden" name="idContact" value="<?= (int) $contact->getIdContact() ?>">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour modifier le site -->
    <div id="popupModifSite" class="modal">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupModifSite')">&times;</span>
            <h5>Ajouter un site</h5>
            <form class = "article justify-content-center infoContactForm" id="addInfoSite" method="POST">
                <div class="row mt-2 justify-content-center">
                    <div class="form-group w-100" id="inputInfoSite">
                        <label for="infoSite">Site internet</label>
                        <input type="text" class="form-control" name="valeur" id="infoSite">
                    </div>
                    <?php if (isset($contact) && $contact instanceof Contact): ?>
                        <input type="hidden" name="champ" value="siteInternet">
                        <input type="hidden" name="idContact" value="<?= (int) $contact->getIdContact() ?>">
                    <?php endif; ?>
                </div>
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour ajouter le SIREN -->
    <div id="popupModifSIREN" class="modal">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupModifSIREN')">&times;</span>
            <h5>Ajouter un SIREN</h5>
            <form class = "article justify-content-center infoContactForm" id="addInfoSIREN" method="POST">
                <div class="row mt-2 justify-content-center">
                    <div class="form-group w-100" id="inputInfoSIREN">
                        <label for="infoSIREN">SIREN</label>
                        <input type="text" class="form-control" name="valeur" id="infoSIREN">
                    </div>
                    
                    <?php if (isset($contact) && $contact instanceof Contact): ?>
                        <input type="hidden" name="champ" value="siren">
                        <input type="hidden" name="idContact" value="<?= (int) $contact->getIdContact() ?>">
                    <?php endif; ?>
                </div>
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour modifier la taille -->
    <div id="popupModifTaille" class="modal" style="display: none;">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupModifTaille')">&times;</span>
            <h3>Interêt</h3>
            <form class = "article justify-content-center col-md-8 infoContactForm" id="modifTailleForm" method="POST">
                <div class="form-group col-md-4 mt-3">
                    <label for="choixTaille">Niveau</label>
                    <select class="form-control" name="valeur" id="choixTaille">
                        <option value="Crèche">Crèche</option>
                        <option value="Micro-crèche">Micro-Crèche</option>
                        <option value="Les deux">Les deux</option>
                    </select>
                </div>
                <input type="hidden" name="idContact" value="<?= (int) $idContact ?>">
                <input type="hidden" name="champ" value="taille">
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button mt-3">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour la confirmation -->
    <div id="popupConfirmation" class="modal" style="display: none;">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <div id="popupConfirmationInfoContactContent">
                <!-- Le contenu dynamique sera injecté ici -->
            </div>
        </div>
    </div>
    <!-- Boîte modale pour ajouter un commentaire -->
    <div id="popupAjoutComment" class="modal" style="display: none;">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupAjoutComment')">&times;</span>
            <h3>Ajouter un commentaire</h3>
            <form class = "article justify-content-center col-md-12" id="addCommentForm" method="POST">
                <div class="form-group col-md-12" id="inputAddComment">
                    <label for="addComment">Commentaire</label>
                    <textarea name="addComment" id="addComment" rows="5" class="form-control"></textarea>
                </div>
                <input type="hidden" name="idContact" value="<?= (int) $idContact ?>">
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button" id="ajoutComment">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour ajouter une localisation -->
    <div id="popupAjoutLocalisation" class="modal" style="display: none;">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupAjoutLocalisation')">&times;</span>
            <h3>Ajouter une localisation</h3>
            <form class = "article justify-content-center col-md-12" id="addNewLocalisationForm" method="POST">
                <div class="row form-row mt-3" id="location">
                    <div class="form-group col-md-3">
                        <label for="newVille">Ville</label>
                        <input class="form-control" list="newVilles" id="newVille" name="newVille" autocomplete="off">
                        <datalist id="newVilles"></datalist>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="newCodePostal">Code postal</label>
                        <input class="form-control" type="text" id="newCodePostal" list="newCodePostaux" name="newCodePostal" autocomplete="off">
                        <datalist id="newCodePostaux"></datalist>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="adresse">Adresse</label>
                        <input class="form-control" id="adresse" name="adresse">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="taille">Taille</label>
                        <select class="form-control" name="taille" id="taille">
                            <option value="Micro-crèche">Micro-crèche</option>
                            <option value="Crèche">Crèche</option>
                        </select>
                    </div>
                </div>
                <?php
                    $nom = isset($contact) ? $contact->getNom() : ''; // Vérification de l'existence de $contact
                ?>
                <input type="hidden" name="nom" value="<?= htmlspecialchars($nom) ?>">
                <input type="hidden" name="idContact" value="<?= (int) $idContact ?>">
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button mt-3">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="js/modifInfosContact.js" defer></script>
<script src="js/codePostal.js" defer></script>
<script src="js/iconCopy.js" defer> </script>

