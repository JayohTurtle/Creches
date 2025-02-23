<div class="container">
    <div class = "row">            
        <div class = "articles col-md-3">
            <div class="article">
                <div class="row col-md-12">
                    <div class="mb-3 col-md-5">
                        <button type="button" class="btn btn-primary" id= "ajoutContact" onclick="ouvrirPopup('popupModifContact')">Modifier</button>
                    </div>
                </div>
                <h5>Identité</h5>
                <?php if ($contact instanceof Contact): ?>
                    <p><strong>Nom: </strong> <?= htmlspecialchars($contact->getNom()) ?></p>
                    <p><strong>Contact: </strong> <?= htmlspecialchars($contact->getContact()) ?></p>
                    <p><strong>Email: </strong> <?= htmlspecialchars($contact->getEmail()) ?></p>
                    <p><strong>Téléphone: </strong> <?= htmlspecialchars($contact->getTelephone()) ?></p>
                    <p><strong>Sens: </strong> <?= htmlspecialchars($contact->getSens()) ?></p>
                    <p><strong>Site Internet: </strong> 
                        <a href="<?= htmlspecialchars($contact->getSiteInternet()) ?>" target="_blank">
                            <?= htmlspecialchars($contact->getSiteInternet()) ?>
                        </a>
                    </p>
                    <p><strong>SIREN: </strong> <?= htmlspecialchars($contact->getSiren()) ?></p>
                <?php else: ?>
                    <p>Aucun contact trouvé.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class = "articles col-md-8">
            <div class="article">
                <div class="row col-md-12">
                    <div class="mb-3 col-md-1">
                        <button type="button" class="btn btn-primary" onclick="ouvrirPopup('popupAjoutComment')">Ajouter</button>
                    </div>
                </div>
                <h5 >Commentaires</h5>
                <ul>
                    <?php if (!empty($commentaires)): ?>
                        <?php foreach ($commentaires as $comment): ?>
                            <li>Le <?= htmlspecialchars($comment->getDateComment()) ?> 
                                <?= htmlspecialchars($comment->getOperateur()) ?> a écrit:
                                <?= htmlspecialchars($comment->getCommentaire()) ?>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>Aucun commentaire trouvé.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class = "articles mt-3 col-md-5">
            <div class = "article">
                <div class="row col-md-12">
                    <div class="mb-3 col-md-3">
                        <button type="button" class="btn btn-primary">Ajouter</button>
                    </div>
                    <div class="mb-3 col-md-6">
                        <button type="button" class="btn btn-danger">Supprimer</button>
                    </div>
                </div>
                <h5>Intérêt général</h5>
                <h6>Ville(s) :</h6>
                <?php if (!empty($interetVilles)): ?>
                    <ul>
                        <?php foreach ($interetVilles as $interetVille): ?>
                            <li>
                                <?= htmlspecialchars($interetVille->getVille()->getVille()) ?>  
                                dans un rayon de <?= htmlspecialchars($interetVille->getRayon()) ?> km
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Aucune ville d'intérêt trouvée.</p>
                <?php endif; ?>
                <h6>Département(s) :</h6>
                <?php if (!empty($interetDepartements)): ?>
                <ul>
                    <?php foreach ($interetDepartements as $interetDepartement): ?>
                        <li>
                            Département : <?= htmlspecialchars($interetDepartement->getDepartement()->getDepartement()) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                    <p>Aucun département d'intérêt trouvé.</p>
                <?php endif; ?>
                <h6>Région(s) :</h6>
                <?php if (!empty($interetRegions)): ?>
                    <ul>
                        <?php foreach ($interetRegions as $interetRegion): ?>
                            <li>
                                Région : <?= htmlspecialchars($interetRegion->getRegion()->getRegion()) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Ce contact n'a pas d'intérêt pour une région.</p>
                <?php endif; ?>
                <?php if ($hasInteretFrance): ?>
                    <h3>Intérêt pour toute la France</h3>
                    <p>Ce contact est intéressé par l’ensemble du territoire français.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class = "articles mt-3 col-md-7">
            <div class = "article">
                <div class="row">
                    <div class="mb-3 col-md-2">
                        <button type="button" class="btn btn-primary">Ajouter</button>
                    </div>
                    <div class="mb-3 col-md-6">
                        <button type="button" class="btn btn-danger">Supprimer</button>
                    </div>
                </div>
                <h5>Intérêt précis</h5>
                <h6>Crèche(s) :</h6>
                <?php if (!empty($interetCreches)): ?>
                    <ul>
                        <?php foreach ($interetCreches as $interet): ?>
                            <li>
                                <strong>Identifiant :</strong> <?= htmlspecialchars($interet->getIdentifiant()) ?><br>
                                <strong>Niveau :</strong> <?= htmlspecialchars($interet->getNiveau()) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Ce contact n’a pas d’intérêts spécifiques pour une de nos crèches en vente.</p>
                <?php endif; ?>
                <h6>Groupe(s) :</h6>
                <?php if (!empty($interetGroupe)): ?>
                    <ul>
                        <?php foreach ($interetGroupe as $interet): ?>
                            <li>
                                <strong>Niveau :</strong> <?= htmlspecialchars($interet->getNiveau()) ?> <br>
                                <strong>Nom :</strong> <?= htmlspecialchars($interet->getNom()) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Ce contact n’a pas d’intérêts spécifiques pour un de nos groupes en vente.</p>
                <?php endif; ?>
                <h6>Taille :</h6>
                <?php if ($interetTaille): ?>
                    <strong>Ce contact recherche :</strong> <?= htmlspecialchars($interetTaille->getTaille()) ?> <br>
                <?php else: ?>
                    <p>Aucune taille renseignée</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class = "articles mt-3 col-md-12">
        <div class = "article">
            <div class=" mb-3">
                <button type="button" class="btn btn-primary">Ajouter une localisation</button>
            </div>
            <?php if (!empty($localisations)): ?>
                <h5>Localisation des crèches</h5>
                <ul>
                    <?php foreach ($localisations as $localisation): ?>
                        <li>
                            Adresse : <?= htmlspecialchars($localisation->getAdresse()) ?>,
                            <?= htmlspecialchars($localisation->getVille()->getVille()) ?>,
                            <?= htmlspecialchars($localisation->getDepartement()->getDepartement()) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucune localisation trouvée.</p>
            <?php endif; ?>
        </div>
    </div>
     <!-- Boîte modale pour modifier un contact -->
     <div id="popupModifContact" class="modal">
        <div class="modal-content form-group d-flex flex-column align-items-center">
            <span class="close" onclick="fermerPopup('popupModifContact')">&times;</span>
            <h3>Ajouter une information sur un contact</h3>
            <form class = "article justify-content-center" id="addInfoContact" method="POST">
                <div class="row w-100">
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="checkbox" name="choixInfoContact" value="contact" id="checkContact">
                            <label for="checkContact">Contact</label>
                        </div>
                        <div class="radio-item ms-2">
                            <input type="checkbox" name="choixInfoContact" value="nom" id="checkNom">
                            <label for="checkNom">Nom</label>
                        </div>
                        <div class="radio-item ms-2">
                            <input type="checkbox" name="choixInfoContact" value="email" id="checkEmail">
                            <label for="checkEmail">Email</label>
                        </div>
                        <div class="radio-item ms-2">
                            <input type="checkbox" name="choixInfoContact" value="telephone" id="checkTelephone">
                            <label for="checkTelephone">Téléphone</label>
                        </div>
                    </div>
                </div>
                <div class="row w-100 mt-3 form-group d-flex flex-column align-items-center">
                    <div class="radio-group">
                        <div class="radio-item ms-4">
                            <input type="checkbox" name="choixInfoContact" value="sens" id="checkSens">
                            <label for="checkSens">Sens</label>
                        </div>
                        <div class="radio-item ms-4">
                            <input type="checkbox" name="choixInfoContact" value="site" id="checkSite">
                            <label for="checkSite">Site Internet</label>
                        </div>
                        <div class="radio-item ms-4">
                            <input type="checkbox" name="choixInfoContact" value="siren" id="checkSiren">
                            <label for="checkSiren">SIREN</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 justify-content-center">
                    <div class="col-md-12">
                    <div class="form-group d-none" id="inputInfoNomGroupe">
                            <label for="infoNomGroupe">Nom du groupe</label>
                            <input type="text" class="form-control" name="infoNomGroupe" id="infoNomGroupe">

                        </div>
                        <div class="form-group" id="inputInfoContact">
                            <label for="infoContact">Contact</label>
                            <input type="text" class="form-control" name="infoContact" id="infoContact">
                        </div>
                        <div class="form-group d-none" id="inputInfoEmail">
                            <label for="infoEmail">Email</label>
                            <input type="email" class="form-control" name="infoEmail" id="infoEmail">
                        </div>
                        <div class="form-group d-none" id="inputInfoTelephone">
                            <label for="infoTelephone">Téléphone</label>
                            <input type="tel" class="form-control" name="infoTelephone" id="infoTelephone">
                        </div>
                        <div class="form-group d-none" id="inputInfoSens">
                            <label for="infoSens">Sens</label>
                            <select class="form-control w-100" name="infoSens" id="infoSens">
                                <option value=""></option>
                                <option value="acheteur">Acheteur</option>
                                <option value="vendeur">Vendeur</option>
                            </select>
                        </div>
                        <div class="form-group d-none" id="inputInfoSite">
                            <label for="infoSite">Site internet</label>
                            <input type="text" class="form-control" name="infoSite" id="infoSite">
                        </div>
                        <div class="form-group d-none" id="inputInfoSIREN">
                            <label for="infoSIREN">SIREN</label>
                            <input type="text" class="form-control" name="infoSIREN" id="infoSIREN">
                        </div>
                        <input type="hidden" name="idContact" value="<?= (int) $idContact ?>">
                    </div>
                </div>
                <div class="form-group col-md-3 d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary small-button">Modifier</button>
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
</div>
<script src="js/popUp.js" defer> </script>