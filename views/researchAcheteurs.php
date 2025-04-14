<div class="container">

    <div class = "row">
        <div class = "articles col-md-4">
            <div class="article contact-article">
                <?php if (isset($contact) && $contact instanceof Contact): ?>
                    <h5> Identité </h5>
                    <p><strong>Nom: </strong> <?= ($contact->getNom()) ?></p>
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
                <?php else: ?>
                    <p>Aucun contact trouvé.</p>
                <?php endif; ?>
                <p><strong>Nombre de crèches: </strong><?= htmlspecialchars($nombreCreches)?></p>
                <?php if (!empty($interetTaille)): ?>
                    <p style="display: flex; align-items: center; gap: 8px;">
                        <strong>Taille recherchée : </strong> <?= htmlspecialchars($interetTaille->getTaille()) ?>
                        <a href="#" onclick="ouvrirPopup('popupModifTaille')"><img class="iconCopie" src="assets/images/modif.png" alt="Modifier"></a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
        <div class = "articles col-md-4">
            <div class = "article contact-article">
                <h5> Niveaux </h5>
                <div>
                    <p><strong>Crèche(s) achetée(s):</strong> <?= htmlspecialchars($interetsCreche["niveauCounts"] ['Achat réalisé']) ?></p>
                </div>
                <div>
                    <p><strong>Offre(s):</strong> <?= htmlspecialchars($interetsCreche["niveauCounts"] ['Sous-offre']) ?></p>
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
                    <p><strong>PNY réalisé:</strong> </p>
                </div>
            </div>
        </div>
        <div class = "articles col-md-3">
            <div class = "article contact-article">
                <h5> 
                Intérêt général
                </h5>
                <p><strong>Ville(s) :</strong></p>
                <?php if (!empty($interetVilles ?? [])): ?>
                    <ul>
                        <?php foreach ($interetVilles as $interetVille): ?>
                            
                            <li>
                                <?= htmlspecialchars($interetVille->getVille()->getVille()) ?> dans un rayon de <?= htmlspecialchars($interetVille->getRayon()) ?> km
                            </li>
                        <?php endforeach; ?>
                        <a href="#" onclick="ouvrirPopup('popupAjoutInteretVille')"><li> Ajouter</li></a>
                    </ul>
                <?php else: ?>
                     <a href="#" onclick="ouvrirPopup('popupAjoutInteretVille')"> <p>Ajouter une ville</p> </a>
                <?php endif; ?>
                <p><strong>Département(s) :</strong></p>
                <?php if (!empty($interetDepartements ?? [])): ?>
                    <ul>
                        <?php foreach ($interetDepartements as $interetDepartement): ?>
                            <li>
                                Département : <?= htmlspecialchars($interetDepartement->getDepartement()->getDepartement()) ?>
                            </li>
                        <?php endforeach; ?>
                        <a href="#" onclick="ouvrirPopup('popupAjoutInteretDepartement')"><li> Ajouter</li></a>
                    </ul>
                <?php else: ?>
                    <a href="#" onclick="ouvrirPopup('popupAjoutInteretDepartement')"> <p>Ajouter un département</p></a>
                <?php endif; ?>
                <p><strong>Région(s) :</strong></p>
                <?php if (!empty($interetRegions ?? [])): ?>
                    <ul>
                        <?php foreach ($interetRegions as $interetRegion): ?>
                            <li>
                                Région : <?= htmlspecialchars($interetRegion->getRegion()->getRegion()) ?>
                            </li>
                        <?php endforeach; ?>
                        <a href="#" onclick="ouvrirPopup('popupAjoutInteretRegion')"> <li>Ajouter</li></a>
                    </ul>
                <?php else: ?>
                    <a href="#" onclick="ouvrirPopup('popupAjoutInteretRegion')"> <p>Ajouter une région</p></a>
                <?php endif; ?>
                <p><strong>France</strong></p>
                <?php if ($hasInteretFrance): ?>
                    <p>Ce contact est intéressé par l’ensemble du territoire français.</p>
                <?php else: ?>
                    <a href="#" onclick="ouvrirPopup('popupAjoutInteretFrance')"> <p>Ajouter France</p></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class = "articles col-md-12 mt-3">
        <div class = "article">
            <h5> Intérêt précis </h5>
            <?php if (!empty($interetsCreche)): ?>
                <ul>
                    <?php foreach ($interetsCreche["interetsCreche"] as $interetCreche): ?>
                        <li>
                            <strong>Crèche :</strong> <?= htmlspecialchars($interetCreche->getLocalisation()->getIdentifiant()) ?><br>
                            <p style="display: flex; align-items: center; gap: 8px;">
                                <strong>Niveau :</strong> <?= htmlspecialchars($interetCreche->getNiveau()) ?><strong> le :</strong> <?= htmlspecialchars($interetCreche->getDateColonneFormatFr()); ?>
                                <a href="#" 
                                    onclick="ouvrirPopup('popupAjoutInteretCreche', 
                                        <?= htmlspecialchars(json_encode($interetCreche->getLocalisation()->getIdentifiant()), ENT_QUOTES, 'UTF-8') ?>, 
                                        <?= htmlspecialchars(json_encode($interetCreche->getNiveau()), ENT_QUOTES, 'UTF-8') ?>)">
                                    <img class="iconCopie" src="assets/images/modif.png" alt="Modifier">
                                </a>
                            </p>
                        </li>
                    <?php endforeach; ?>
                    <a href="#" onclick="ouvrirPopup('popupAjoutInteretCreche')"> <li>Nouveau</li></a>
                </ul>
            <?php else: ?>
                <a href="#" onclick="ouvrirPopup('popupAjoutInteretCreche')"> <p>Ajouter un intérêt pour une crèche</p></a>
            <?php endif; ?>
        </div>
    </div>
    <div class = "articles col-md-12 mt-3">
        <div class="article">
            <h5 >Commentaires</h5>
            <ul>
                <?php if (!empty($commentaires)): ?>
                    <?php foreach ($commentaires as $comment): ?>
                        <li>Le <?= htmlspecialchars($comment->getDateCommentFormatFr()); ?> 
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
    <div class = "articles col-md-12">
        <div class = "article">
            <?php if (!empty($localisations)): ?>
                <h5>Localisation des crèches</h5>
                <ul>
                    <?php foreach ($localisations as $localisation): ?>
                        <li>
                            <a href="index.php?action=creche&idLocalisation=<?= urlencode($localisation->getIdLocalisation()) ?>">
                                Adresse : <?= htmlspecialchars($localisation->getAdresse()) ?>,
                                <?= htmlspecialchars($localisation->getVille()->getVille()) ?>,
                                <?= htmlspecialchars($localisation->getDepartement()->getDepartement()) ?>,
                                <?= htmlspecialchars($localisation->getRegion()->getRegion()) ?>
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
            <form class = "article justify-content-center col-md-8" id="modifTailleForm" method="POST">
                <div class="form-group col-md-4 mt-3">
                    <label for="choixTaille">Niveau</label>
                    <select class="form-control" name="taille" id="choixTaille">
                        <option value="Crèche">Crèche</option>
                        <option value="Micro-crèche">Micro-Crèche</option>
                        <option value="Les deux">Les deux</option>
                    </select>
                </div>
                <input type="hidden" name="idContact" value="<?= (int) $idContact ?>">
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
    <!-- Boîte modale pour ajouter un intérêt sur une crèche -->
    <div id="popupAjoutInteretCreche" class="modal col-md-4" style="display: none;">
    <div class="modal-content form-group d-flex flex-column align-items-center">
        <span class="close" onclick="fermerPopup('popupAjoutInteretCreche')">&times;</span>
        <h3>Intérêt</h3>
        <form class="article justify-content-center col-md-12" id="addInterestCrecheForm" method="POST">
            <div class="form-group mt-3">
                <label for="niveauInteret">Niveau</label>
                <select class="form-control w-100" name="niveauInteret" id="niveauInteret">
                    <option value="Intéressé">Intéressé</option>
                    <option value="NDA envoyé">NDA envoyé</option>
                    <option value="Dossier envoyé">Dossier envoyé</option>
                    <option value="Sous-offre">Sous-offre</option>
                    <option value="Achat réalisé">Achat réalisé</option>
                </select>
            </div>
            <div class="form-group col-md-10 mt-3" id="inputChoixInteretCreche">
                <label for="identifiant">Sur une crèche</label>
                <input type="text" class="form-control" name="interetCreche" id="interetCreche" list="getIdentifiants"
                    value="">  <!-- L'input sera mis à jour dynamiquement -->
                <datalist id="getIdentifiants">
                    <?php if (!empty($localisationsAVendre) && is_array($localisationsAVendre)): ?>
                        <?php foreach ($localisationsAVendre as $localisationAVendre) : ?>
                            <?php if ($localisationAVendre instanceof Localisation): ?>
                                <option value="<?= htmlspecialchars($localisationAVendre->getIdentifiant()) ?>"></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucune localisation disponible.</p>
                    <?php endif; ?>
                </datalist>
            </div>
            <input type="hidden" name="idContact" value="<?= (int) $idContact ?>">
            <div class="form-group col-md-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary small-button" id="ajoutInteretCreche">Envoyer</button>
            </div>
        </form>
    </div>
</div>
    </div>
    <!-- Boîte modale pour ajouter un intérêt sur une ville -->
    <div id="popupAjoutInteretVille" class="modal" style="display: none;">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupAjoutInteretVille')">&times;</span>
            <h3>Ajouter un interêt</h3>
            <form class = "article justify-content-center col-md-12" id="addInterestVilleForm" method="POST">
                <div class="row form-row justify-content-center mt-3" id="inputChoixInteretVille">
                    <div class="form-group col-md-5">
                        <label for="villeInterest">Ville</label>
                        <input class="form-control general-input" list="villesInterest" id="villeInterest" name="villeInterest" autocomplete="off">
                        <datalist id="villesInterest">
                            <option value=""></option>
                        </datalist>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="codePostalInterest">Code postal</label>
                        <input class="form-control general-input" id="codePostalInterest" name="codePostalInterest" autocomplete="off">
                        <datalist id="codePostauxInterest"></datalist>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="rayonInterest">Rayon</label>
                        <input class="form-control general-input" id="rayonInterest" name="rayonInterest">
                    </div>
                </div>
                <input type="hidden" name="idContact" value="<?= (int) $idContact ?>">
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button" id="ajoutInteretVille">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour ajouter un intérêt sur un département-->
    <div id="popupAjoutInteretDepartement" class="modal" style="display: none;">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupAjoutInteretDepartement')">&times;</span>
            <h3>Ajouter un interêt</h3>
            <form class = "article justify-content-center col-md-12" id="addInterestDepartementForm" method="POST">
                <div class="form-group col-md-8 mt-3" id="inputChoixInteretDepartement">
                    <label for="departementInterest">Département</label>
                    <input class="form-control general-input" list="departementsInterest" id="departementInterest" name="departementInterest" autocomplete="off">
                    <datalist id="departementsInterest">
                       <?php 
                            foreach ($departements as $departement) : ?>
                                <option value="<?php echo htmlspecialchars($departement -> getDepartement()); ?>"></option>
                            <?php endforeach; 
                        ?>
                    </datalist>
                </div>
                <input type="hidden" name="idContact" value="<?= (int) $idContact ?>">
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button" id="ajoutInteretDepartement">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour ajouter un intérêt sur une région-->
    <div id="popupAjoutInteretRegion" class="modal" style="display: none;">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupAjoutInteretRegion')">&times;</span>
            <h3>Ajouter un interêt</h3>
            <form class = "article justify-content-center col-md-12" id="addInterestRegionForm" method="POST">
                <div class="form-group col-md-8 mt-3" id="inputChoixInteretRegion">
                    <label for="regionInterest">Région</label>
                    <input class="form-control general-input" list="regionsInterest" id="regionInterest" name="regionInterest" autocomplete="off">
                    <datalist id="regionsInterest">
                       <?php 
                            foreach ($regions as $region) : ?>
                                <option value="<?php echo htmlspecialchars($region -> getRegion()); ?>"></option>
                            <?php endforeach; 
                        ?>
                    </datalist>
                </div>
                <input type="hidden" name="idContact" value="<?= (int) $idContact ?>">
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button" id="ajoutInteretRegion">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Boîte modale pour ajouter un intérêt sur la France-->
    <div id="popupAjoutInteretFrance" class="modal" style="display: none;">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupAjoutInteretFrance')">&times;</span>
            <h3>Ajouter un interêt pour la France ?</h3>
            <form class = "article justify-content-center col-md-12" id="addInterestFranceForm" method="POST">
                <input type="hidden" name="idContact" value="<?= (int) $idContact ?>">
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button" id="ajoutInteretFrance">Confirmer</button>
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
