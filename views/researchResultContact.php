
<div class = "container">
    <div class = "row">            
        <div class = "articles col-md-3">
            <div class="article">
                <div class="row col-md-12">
                    <div class="mb-3 col-md-5">
                        <button type="button" class="btn btn-primary">Ajouter</button>
                    </div>
                    <div class="mb-3 col-md-6 ms-2">
                        <button type="button" class="btn btn-success">Modifier</button>
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
                        <button type="button" class="btn btn-primary">Ajouter</button>
                    </div>
                    <div class="mb-3 col-md-6 ms-5">
                        <button type="button" class="btn btn-success">Modifier</button>
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
                        <button type="button" class="btn btn-success">Modifier</button>
                    </div>
                </div>
                <h5>Intérêt général</h5>
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
                <?php else: ?>
                    <p>Ce contact n’a pas d’intérêt général pour la France.</p>
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
                        <button type="button" class="btn btn-success">Modifier</button>
                    </div>
                </div>
                <h5>Intérêt précis</h5>
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
                <?php if (!empty($interetGroupe)): ?>
                    <ul>
                        <?php foreach ($interetGroupe as $interet): ?>
                            <li>
                                <strong>Niveau :</strong> <?= htmlspecialchars($interetGroupe->getNiveau()) ?> <br>
                                <strong>Nom :</strong> <?= htmlspecialchars($interetGroupe->getNom()) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Ce contact n’a pas d’intérêts spécifiques pour un de nos groupes en vente.</p>
                <?php endif; ?>
                <?php if ($interetTaille): ?>
                    <strong>Ce contact recherche :</strong> <?= htmlspecialchars($interetTaille->getTaille()) ?> <br>
                <?php else: ?>
                    <strong>Aucune taille renseignée</strong>
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
</div>