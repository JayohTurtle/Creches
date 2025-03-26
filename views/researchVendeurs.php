<div class="container">
    <div class = "row mt3">
        <div class = "articles col-md-4">
            <div class="article client-article">
                <?php if (isset($client) && $client instanceof Contact): ?>
                    <h5> Identité</h5>
                    <p><strong>Nom: </strong> <?= htmlspecialchars($client->getNom()) ?></p>
                    <p><strong>Contact: </strong> <?= htmlspecialchars($client->getContact()) ?></p>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <strong>Email: </strong>
                        <span id="emailACopier_<?= htmlspecialchars($client->getEmail()) ?>"><?= htmlspecialchars($client->getEmail()) ?></span>
                        <img class="iconCopie" src="assets/images/copier.png" alt="Copier" onclick="copierTextePopup('emailACopier_<?= htmlspecialchars($client->getEmail()) ?>', this)">
                        <a href="#" onclick="ouvrirPopup('popupModifEmail')"><img class="iconCopie" src="assets/images/modif.png" alt="Modifier"></a>
                    </p>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <strong>Téléphone: </strong><?= htmlspecialchars($client->getTelephone()) ?>
                        <a href="#" onclick="ouvrirPopup('popupModifTelephone')"><img class="iconCopie" src="assets/images/modif.png" alt="Modifier"></a>
                    </p>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <strong>Sens: </strong><?= htmlspecialchars($client->getSens()) ?>
                        <a href="#" onclick="ouvrirPopup('popupModifSens')"><img class="iconCopie" src="assets/images/modif.png" alt="Modifier"></a>
                    </p>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <strong>Site Internet: </strong>
                        <a href="<?= htmlspecialchars($client->getSiteInternet()) ?>" target="_blank">
                            <?= htmlspecialchars($client->getSiteInternet()) ?>
                        </a>
                        <a href="#" onclick="ouvrirPopup('popupModifSite')"><img class="iconCopie" src="assets/images/modif.png" alt="Modifier"></a>
                    </p>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <strong>SIREN: </strong>
                        <span id="sirenACopier_<?= urlencode($client->getSiren()) ?>"><?= htmlspecialchars($client->getSiren()) ?></span>
                        <img class="iconCopie" src="assets/images/copier.png" alt="Copier" onclick="copierTextePopup('sirenACopier_<?= htmlspecialchars($client->getSiren()) ?>', this)">
                        <a href="#" onclick="ouvrirPopup('popupModifSIREN')"><img class="iconCopie" src="assets/images/modif.png" alt="Modifier"></a>
                    </p>
                        <?php else: ?>
                    <p>Aucun contact trouvé.</p>
                <?php endif; ?>
                <?php if (isset($clientData) && $clientData instanceof Client): ?>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <strong>Statut: </strong><?= htmlspecialchars($clientData->getStatut()) ?>
                        <a href="#" onclick="ouvrirPopup('popupModifStatut')"><img class="iconCopie" src="assets/images/modif.png" alt="Modifier"></a>
                    </p>
                    <p><strong>Date du statut: </strong> <?= htmlspecialchars($clientData->getDateStatutFormatFr()) ?></p>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <strong>Valorisation: </strong><?= $formatter->formatCurrency($clientData->getValorisation(), 'EUR') ?>
                        <a href="#" onclick="ouvrirPopup('popupModifValorisation')"><img class="iconCopie" src="assets/images/modif.png" alt="Modifier"></a>
                    </p>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <strong>Commission: </strong><?= $formatter->formatCurrency($clientData->getCommission(), 'EUR') ?>
                        <a href="#" onclick="ouvrirPopup('popupModifCommission')"><img class="iconCopie" src="assets/images/modif.png" alt="Modifier"></a>
                    </p>
                <?php endif; ?>
                <p><strong>Nombre de crèches: </strong><?= htmlspecialchars($nombreCreches)?></p>
            </div>
        </div>
        <div class = "articles col-md-2">
            <div class="article client-article">
                <h5> Niveaux </h5>
                <div>
                    <p><strong>Crèche(s) vendue(s):</strong> <?= htmlspecialchars($interetsCreche["niveauCounts"] ['Achat réalisé']) ?></p>
                </div>
                <div>
                    <p><strong>Sous offre(s):</strong> <?= htmlspecialchars($interetsCreche["niveauCounts"] ['LOI']) ?></p>
                </div>
                <div>
                    <p><strong>Dossier(s) envoyé(s):</strong> <?= htmlspecialchars($interetsCreche["niveauCounts"] ['Dossier envoyé']) ?></p>
                </div>
                <div>
                    <p><strong>NDA envoyé(s):</strong> <?= htmlspecialchars($interetsCreche["niveauCounts"] ['NDA envoyé']) ?></p>
                </div>
                <div>
                    <p><strong>Simple(s) intérêt(s):</strong> <?= htmlspecialchars($interetsCreche["niveauCounts"] ['Intéressé']) ?></p>
                </div>
                <div>
                    <p><strong>PNY réalisé: </strong><?= number_format (htmlspecialchars($clientData->getCommission()), 2, ',', ' ') ?> € </p>
                </div>
            </div>
        </div>
        <div class="articles col-md-6 mt-3">
            <div class="article">
                <h5 >Localisations</h5>
                <ul>
                    <?php foreach ($localisations as $localisation): ?>
                        <div>
                            <strong>
                               <li> <a href="index.php?action=creche&idLocalisation=<?= urlencode($localisation->getIdLocalisation()) ?>">
                                        <?= htmlspecialchars($localisation->getAdresse()) ?>, 
                                        <?= htmlspecialchars($localisation->getVille()->getVille()) ?>, 
                                        <?= htmlspecialchars($localisation->getDepartement()->getDepartement()) ?>, 
                                        <?= htmlspecialchars($localisation->getRegion()->getRegion()) ?>
                                    </a>
                                </li>
                            </strong>
                        </div>
                    <?php endforeach; ?>
                </ul>
                <div class=" mb-3">
                    <i class="fas fa-plus-circle text-secondary" style="font-size: 1.5rem; cursor: pointer;" onclick="ouvrirPopup('popupAjoutLocalisation')"></i>
                </div>
            </div>
        </div>
    </div>
    <div class = "articles col-md-12 mt-3">
        <div class="article">
            <h5 ><a href="">Commentaires</a></h5>
            <ul>
                <?php if (!empty($commentaires)): ?>
                    <?php foreach ($commentaires as $comment): ?>
                        <li>Le <?php echo htmlspecialchars($comment->getDateCommentFormatFr()); ?> 
                            , <?= htmlspecialchars($comment->getOperateur()) ?> a écrit :
                            <?= htmlspecialchars($comment->getCommentaire()) ?>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Aucun commentaire trouvé.</li>
                <?php endif; ?>
            </ul>
            <div class=" mb-3">
                <i class="fas fa-plus-circle text-secondary" style="font-size: 1.5rem; cursor: pointer;" onclick="ouvrirPopup('popupAjoutComment')"></i>
            </div>
        </div>
    </div>

    <!-- Boîte modale pour modifier un email -->
    <div id="popupModifEmail" class="modal">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupModifEmail')">&times;</span>
            <h5>Ajouter/modifier un email</h5>
            <form class = "article justify-content-center" id="addEmail" method="POST">
                <div class="row mt-2 justify-content-center">
                    <div class="form-group w-100" id="inputInfoEmail">
                        <label for="infoEmail">Email</label>
                        <input type="email" class="form-control" name="infoEmail" id="infoEmail">
                    </div>
                    <?php if (isset($client) && $client instanceof Contact): ?>
                        <input type="hidden" name="idContact" value="<?= (int) $client->getIdContact() ?>">
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
            <form class = "article justify-content-center" id="addInfoContact" method="POST">
                <div class="row mt-2 justify-content-center">
                    <div class="form-group w-100" id="inputInfoTelephone">
                        <label for="infoTelephone">Téléphone</label>
                        <input type="tel" class="form-control" name="infoTelephone" id="infoTelephone">
                    </div>                        
                    <?php if (isset($client) && $client instanceof Contact): ?>
                        <input type="hidden" name="idContact" value="<?= (int) $client->getIdContact() ?>">
                    <?php endif; ?>
                </div>
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour modifier un statut -->
    <div id="popupModifStatut" class="modal">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupModifStatut')">&times;</span>
            <h5>Modifier le statut</h5>
            <form class = "article justify-content-center" id="addInfoStatut" method="POST">
                <div class="row mt-2 justify-content-center">
                    <div class="form-group w-100" id="inputInfoStatut">
                        <label for="infoStatut">Statut</label>
                        <select class="form-control" name="infoStatut" id="infoStatut">
                            <option value="Approche">Approche</option>
                            <option value="Négociation">Négociation</option>
                            <option value="Mandat envoyé">Mandat envoyé</option>
                            <option value="Mandat signé">Mandat signé</option>
                            <option value="Vendu">Vendu</option>
                        </select>
                        <?php if (isset($client) && $client instanceof Contact): ?>
                            <input type="hidden" name="idContact" value="<?= (int) $client->getIdContact() ?>">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour modifier le sens -->
    <div id="popupModifSens" class="modal">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupModifSens')">&times;</span>
            <h5>Modifier le sens</h5>
            <form class = "article justify-content-center" id="addInfoSens" method="POST">
                <div class="row mt-2 justify-content-center">
                    <div class="form-group w-100" id="inputInfoSens">
                        <label for="infoSens">Sens</label>
                        <select class="form-control w-100" name="infoSens" id="infoSens">
                            <option value=""></option>
                            <option value="acheteur">Acheteur</option>
                            <option value="vendeur">Vendeur</option>
                        </select>
                        <?php if (isset($client) && $client instanceof Contact): ?>
                            <input type="hidden" name="idContact" value="<?= (int) $client->getIdContact() ?>">
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
            <form class = "article justify-content-center" id="addInfoSite" method="POST">
                <div class="row mt-2 justify-content-center">
                    <div class="form-group w-100" id="inputInfoSite">
                        <label for="infoSite">Site internet</label>
                        <input type="text" class="form-control" name="infoSite" id="infoSite">
                    </div>                        
                    <?php if (isset($client) && $client instanceof Contact): ?>
                        <input type="hidden" name="idContact" value="<?= (int) $client->getIdContact() ?>">
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
            <form class = "article justify-content-center" id="addInfoSIREN" method="POST">
                <div class="row mt-2 justify-content-center">
                    <div class="form-group" id="inputInfoSIREN">
                        <label for="infoSIREN">SIREN</label>
                        <input type="text" class="form-control" name="infoSIREN" id="infoSIREN">
                    </div>
                    
                    <?php if (isset($client) && $client instanceof Contact): ?>
                        <input type="hidden" name="idContact" value="<?= (int) $client->getIdContact() ?>">
                    <?php endif; ?>
                </div>
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour ajouter la valorisation -->
    <div id="popupModifValorisation" class="modal">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupModifValorisation')">&times;</span>
            <h5>Ajouter une valorisation</h5>
            <form class = "article justify-content-center" id="addValorisationForm" method="POST">
                <div class="row mt-2 justify-content-center">
                    <div class="form-group w-100" id="inputInfoValorisation">
                        <label for="infoValorisation">Valorisation</label>
                        <input type="text" class="form-control" name="infoValorisation" id="infoValorisation">
                    </div>
                    
                    <?php if (isset($client) && $client instanceof Contact): ?>
                        <input type="hidden" name="idContact" value="<?= (int) $client->getIdContact() ?>">
                    <?php endif; ?>
                </div>
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour ajouter la commission -->
    <div id="popupModifCommission" class="modal">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupModifCommission')">&times;</span>
            <h5>Ajouter une Commission</h5>
            <form class = "article justify-content-center" id="addCommissionForm" method="POST">
                <div class="row mt-2 justify-content-center">
                    <div class="form-group w-100" id="inputInfoCommission">
                        <label for="infoCommission">Commission</label>
                        <input type="text" class="form-control" name="infoCommission" id="infoCommission">
                    </div>
                    
                    <?php if (isset($client) && $client instanceof Contact): ?>
                        <input type="hidden" name="idContact" value="<?= (int) $client->getIdContact() ?>">
                    <?php endif; ?>
                </div>
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button">Envoyer</button>
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
    <!-- Boîte modale pour ajouter un commentaire -->
    <div id="popupAjoutComment" class="modal" style="display: none;">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupAjoutComment')">&times;</span>
            <h3>Ajouter un commentaire</h3>
            <form class = "article justify-content-center col-md-12" id="addCommentForm" method="POST" autocomplete="new-password">
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
    <!-- Boîte modale pour la confirmation -->
    <div id="popupConfirmation" class="modal" style="display: none;">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <div id="popupConfirmationInfoContactContent">
                <!-- Le contenu dynamique sera injecté ici -->
            </div>
        </div>
    </div>
</div>
<script src="js/modifInfosContact.js" defer> </script>
<script src="js/codePostal.js" defer></script>
<script src="js/iconCopy.js" defer> </script>