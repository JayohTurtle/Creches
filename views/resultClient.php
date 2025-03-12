<div class="container">
    <div class = "row">
        <div class = "articles col-md-3">
            <div class="article client-article">
                <?php if (isset($client) && $client instanceof Contact): ?>
                    <h5> 
                    <a href="#" onclick="ouvrirPopup('popupModifContact')">Identité</a>
                    </h5>
                    <p><strong>Nom: </strong> <?= htmlspecialchars($client->getNom()) ?></p>
                    <p><strong>Contact: </strong> <?= htmlspecialchars($client->getContact()) ?></p>
                    <p><strong>Email: </strong> <?= htmlspecialchars($client->getEmail()) ?></p>
                    <p><strong>Téléphone: </strong> <?= htmlspecialchars($client->getTelephone()) ?></p>
                    <p><strong>Sens: </strong> <?= htmlspecialchars($client->getSens()) ?></p>
                    <p><strong>Site Internet: </strong> 
                        <a href="<?= htmlspecialchars($client->getSiteInternet()) ?>" target="_blank">
                            <?= htmlspecialchars($client->getSiteInternet()) ?>
                        </a>
                    <p></p>
                    <p><strong>SIREN: </strong> <?= htmlspecialchars($client->getSiren()) ?></p>
                <?php else: ?>
                    <p>Aucun contact trouvé.</p>
                <?php endif; ?>
                <?php if (isset($clientData) && $clientData instanceof Client): ?>
                    <p><strong>Statut: </strong> <?= htmlspecialchars($clientData->getStatut()) ?></p>
                    <p><strong>Date du statu: </strong> <?= htmlspecialchars($clientData->getDateStatutFormatFr()) ?></p>
                <?php endif; ?>
                <p><strong>Nombre de crèches: </strong><?= htmlspecialchars($nombreCreches)?></p>
            </div>
        </div>
        <div class = "articles col-md-9">
            <div class="article">
                <h5 >Intérêts sur le groupe</h5>
                <?php if (!empty($interetsGroupe)): ?>
                    <div class="row">
                        <?php foreach ($interetsGroupe as $interetGroupe): ?>
                            <article class="col-md-4">
                                <h6><?= htmlspecialchars($interetGroupe->getNiveau()) ?></h6>
                                <ul>
                                    <li><?= htmlspecialchars($interetGroupe->getDateInteretFormatFr()) ?></li>
                                    <li><?= htmlspecialchars($interetGroupe->getContact()->getContact()) ?></li>
                                    <li><?= htmlspecialchars($interetGroupe->getContact()->getNom()) ?></li>   
                                    <li><?= htmlspecialchars($interetGroupe->getContact()->getTelephone()) ?></li>    
                                    <li><?= htmlspecialchars($interetGroupe->getContact()->getEmail()) ?></li>
                                </ul>
                            </article>
                        <?php endforeach;?>
                    </div>
                <?php else: ?>
                    <li>Aucun interet trouvé.</li>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="articles col-md-12 mt-3">
        <div class="article">
            <h5>Intérêts sur les crèches</h5>
        </div>
            <ul>
                <?php if (!empty($interetsCreche)): ?>
                    <?php foreach ($interetsCreche as $interetCreche): ?>
                        <div class="article mt-2 mb-2">
                            <div>
                                <h6>
                                    <a href="index.php?action=creche&identifiant=<?= urlencode($interetCreche->getLocalisation()->getIdentifiant()) ?>">
                                        <?= htmlspecialchars($interetCreche->getLocalisation()->getAdresse()) ?>, 
                                        <?= htmlspecialchars($interetCreche->getVille()->getVille()) ?>, 
                                        <?= htmlspecialchars($interetCreche->getDepartement()->getDepartement()) ?>, 
                                        <?= htmlspecialchars($interetCreche->getRegion()->getRegion()) ?>
                                    </a>
                                </h6>
                            </div>
                            <div>
                                <?php if (!empty($interetCreche->getContact())): ?>
                                    <ul>
                                        <?php foreach ($interetCreche->getContact() as $contact): ?>
                                            <li>
                                                <strong><?= htmlspecialchars($contact->getNiveau()) ?></strong> - 
                                                <a href="index.php?action=resultAcheteur&idContact=<?= urlencode($contact->getIdContact()) ?>">
                                                    <?= htmlspecialchars($contact->getNom()) ?> (<?= htmlspecialchars($contact->getContact()) ?>)
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p>Aucun contact enregistré pour cette crèche.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php foreach ($localisations as $localisation): ?>
                        <div>
                            <h6>
                                <a href="index.php?action=creche&identifiant=<?= urlencode($localisation->getIdentifiant()) ?>">
                                    <?= htmlspecialchars($localisation->getAdresse()) ?>, 
                                    <?= htmlspecialchars($localisation->getVille()->getVille()) ?>, 
                                    <?= htmlspecialchars($localisation->getDepartement()->getDepartement()) ?>, 
                                    <?= htmlspecialchars($localisation->getRegion()->getRegion()) ?>
                                </a>
                            </h6>
                        </div>
                        <p>Aucun intérêt enregistré pour cette crèche.</p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
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
                            <input type="checkbox" name="choixInfoContact" value="telephone" id="checkTelephone">
                            <label for="checkTelephone">Téléphone</label>
                        </div>
                        <div class="radio-item ms-4">
                            <input type="checkbox" name="choixInfoContact" value="email" id="checkEmail">
                            <label for="checkEmail">Email</label>
                        </div>
                        <div class="radio-item ms-4">
                            <input type="checkbox" name="choixInfoContact" value="statut" id="checkStatut">
                            <label for="checkStatut">Statut</label>
                        </div>
                    </div>
                </div>
                <div class="row w-100 form-group d-flex flex-column align-items-center">
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="checkbox" name="choixInfoContact" value="sens" id="checkSens">
                            <label for="checkSens">Sens</label>
                        </div>
                        <div class="radio-item ms-2">
                            <input type="checkbox" name="choixInfoContact" value="siren" id="checkSiren">
                            <label for="checkSiren">SIREN</label>
                        </div>
                        <div class="radio-item ms-2">
                            <input type="checkbox" name="choixInfoContact" value="site" id="checkSite">
                            <label for="checkSite">Site Internet</label>
                        </div>
                        
                    </div>
                </div>
                <div class="row mt-2 justify-content-center">
                    <div class="col-md-12">
                        <div class="form-group d-none" id="inputInfoTelephone">
                            <label for="infoTelephone">Téléphone</label>
                            <input type="tel" class="form-control" name="infoTelephone" id="infoTelephone">
                        </div>
                        <div class="form-group d-none" id="inputInfoEmail">
                            <label for="infoEmail">Email</label>
                            <input type="email" class="form-control" name="infoEmail" id="infoEmail">
                        </div>
                        <div class="form-group d-none" id="inputInfoStatut">
                            <label for="infoStatut">Statut</label>
                            <select class="form-control" name="infoStatut" id="infoStatut">
                                <option value="Approche">Approche</option>
                                <option value="Négociation">Négociation</option>
                                <option value="Mandat envoyé">Mandat envoyé</option>
                                <option value="Mandat signé">Mandat signé</option>
                                <option value="Vendu">Vendu</option>
                            </select>
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
                        
                        <?php if (isset($client) && $client instanceof Contact): ?>
                            <input type="hidden" name="idContact" value="<?= (int) $client->getIdContact() ?>">
                        <?php endif; ?>
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
</div>
<script src="js/resultClient.js" defer> </script>