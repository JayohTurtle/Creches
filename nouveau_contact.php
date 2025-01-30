<?php


require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/config/databaseconnect.php');

$operateur = 'jzabiolle@youinvest.fr';
/**
 * Récupération des variables
 */
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $postData = $_POST;

    $contact = trim(strip_tags($postData['contact']));
    $nom = trim(strip_tags($postData['nom']));
    $email = trim(strip_tags($postData['email']));
    $telephone = trim(strip_tags($postData['telephone']));
    $sens = trim(strip_tags($postData['directionChoice']));
    $comment = trim(strip_tags($postData['comment']));
    $dateJour = date("Y/m/d");

    // On vérifie qu'il y a un commentaire
    if (isset($_POST['comment'])) {
        // On intègre le commentaire dans la base de données
        $insertComment = $mysqlCreche->prepare('INSERT INTO commentaires(nom, contact, commentaire, date_comment, operateur) VALUES (:nom, :contact, :commentaire, :date_comment, :operateur)');

        $insertComment->execute([
            'nom' => $nom,
            'contact' => $contact,
            'commentaire' => $comment,
            'date_comment' => $dateJour,
            'operateur' => $operateur,
        ]);
    }

    //On vérifie si le contact existe déjà dans la base de données
    $checkContact = $mysqlCreche->prepare('SELECT * FROM contacts WHERE contact = :contact AND email = :email');
    $checkContact->execute([
        'contact' => $contact,
        'email' => $email,
    ]);

    //Si le contact n'existe pas, on l'ajoute
    if (!$checkContact->rowCount() > 0) {
        //on entre le contact dans la base de données
        $insertContact = $mysqlCreche->prepare('INSERT INTO contacts(nom, contact, email, telephone, sens) VALUES (:nom, :contact, :email, :telephone, :sens)');

        $insertContact->execute([
            'nom' => $nom,
            'contact' => $contact,
            'email' => $email,
            'telephone' => $telephone,
            'sens' => $sens
    ]);
    }

    //on ajoute la ville, le code postal et le département
    //Comme il peut y'avoir plusieurs lignes on boucle sur les input
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'ville') === 0) {
            $ville = trim(strip_tags($value));
            //on récupère le code postal
            $postalCodeKey = 'postalCode' . substr($key, 5);
            if (isset($_POST[$postalCodeKey])) {
                $postalCode = trim(strip_tags($_POST[$postalCodeKey]));
                
                //on vérifie si la ville existe déjà dans la base villes
                $checkVille = $mysqlCreche->prepare('SELECT * FROM villes WHERE ville = :ville');
                $checkVille->execute(['ville' => $ville]);
                
                //si elle exista pas on l'ajoute
                if (!$checkVille->rowCount() > 0) {
                    $insertVille = $mysqlCreche->prepare('INSERT INTO villes(ville, code_postal) VALUES (:ville, :postalCode)');
                    $insertVille->execute([
                        'ville' => $ville,
                        'postalCode' => $postalCode, 
                    ]);
                }
            }
            
            // on ajoute le dept dans la base départements
            $departementKey = 'departement' . substr($key, 5);
            if (isset($_POST[$departementKey])) {
                $departement = trim(strip_tags($_POST[$departementKey]));
                
                //on vérifie qu'il n'est pas déjà dans la base
                $checkDepartement = $mysqlCreche->prepare('SELECT * FROM departements WHERE departement = :departement');
                $checkDepartement->execute(['departement' => $departement]);
                
                //s'il est pas dans la base, on l'ajoute
                if (!$checkDepartement->rowCount() > 0) {
                    $insertDepartement = $mysqlCreche->prepare('INSERT INTO departements (departement) VALUES (:departement)');
                    $insertDepartement->execute([
                        'departement' => $departement,
                    ]);
                }
            }

            //on remplit la base de données localisation
            $insertLocalisation = $mysqlCreche->prepare('INSERT INTO localisation (nom, contact, ville, departement) VALUES (:nom, :contact, :ville, :departement)');
            $insertLocalisation -> execute([
                'nom' => $nom,
                'contact' => $contact,
                'ville' => $ville,
                'departement' => $departement,
            ]);
        }
    }
    //on ajoute les intérêts
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'niveau') === 0) {
            $niveau = trim(strip_tags($value));
    
            $villeInterestKey = 'villeInterest' . substr($key, 6); // 6 correspond à la longueur de 'niveau'
            $departementInterestKey = 'departementInterest' . substr($key, 6); // 6 correspond à la longueur de 'niveau'
            $identifierKey = 'identifierInterest' . substr($key, 6); // 6 correspond à la longueur de 'niveau'
    
            $villeInterest = isset($_POST[$villeInterestKey]) ? trim(strip_tags($_POST[$villeInterestKey])) : '';
            $departementInterest = isset($_POST[$departementInterestKey]) ? trim(strip_tags($_POST[$departementInterestKey])) : '';
            $identifier = isset($_POST[$identifierKey]) ? trim(strip_tags($_POST[$identifierKey])) : '';
    
            $insertInterest = $mysqlCreche->prepare('INSERT INTO interet (niveau, contact, ville, departement, identifiant) VALUES (:niveau, :contact, :ville, :departement, :identifiant)');
            $insertInterest->execute([
                'niveau' => $niveau,
                'contact' => $contact,
                'ville' => $villeInterest,
                'departement' => $departementInterest,
                'identifiant' => $identifier
            ]);
        }
    }
}

require_once(__DIR__ . '/views/head.php'); 
 
?>

<body>
    <?php require_once(__DIR__ . '/views/header.php'); ?>
    <div class="container">
        <div class="container form-container mt-5">
            <form id="form" method="post" action="nouveau_contact.php">
                <h5 class="mt-3">Identité</h5>
                <div class="row form-row mt-3">
                    <div class="form-group col-md-6">
                        <label for="contact">Contact</label>
                        <input type="text" class="form-control" name="contact" id="contact">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nom">Nom du groupe</label>
                        <input type="text" class="form-control" name="nom" id="nom">
                    </div>
                </div>
                <div class="row form-row mt-3">
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                        <small class="form-text">Message d'erreur</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="telephone">Téléphone</label>
                        <input type="text" class="form-control" name="telephone" id="telephone">
                        <small class="form-text">Message d'erreur</small>
                    </div>
                </div>
                <div class="row form-row mt-3">    
                    <div class="form-group col-md-3">
                        <p>Sens</p>
                        <input type="radio" id="buyer" name="directionChoice" value="Acheteur" checked>
                        <label for="buyer">Acheteur</label><br>
                        <input type="radio" id="seller" name="directionChoice" value="Vendeur">
                        <label for="seller">Vendeur</label><br>
                    </div>
                    <div class="form-group col-md-9">
                        <label for="comment">Commentaire</label>
                        <textarea name="comment" id="comment" rows="2" class="form-control"></textarea>
                    </div>
                </div>
                <h5 class="mt-3">Localisation de/des crèches</h5>
                <div class="row form-row mt-3" id="adresse">
                    <div class="form-group col-md-3">
                        <label for="ville">Ville</label>
                        <input class="form-control" list="villes" id="ville" name="ville">
                        <datalist id="villes">
                            <?php
                                include(__DIR__ . '/views/options_villes.php');
                            ?>
                        </datalist>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="postalCode">Code postal</label>
                        <input class="form-control" id="postalCode" name="postalCode">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="departement">Département</label>
                        <input class="form-control" list="departements" id="departement" name="departement">
                        <datalist id="departements">
                            <?php
                                include(__DIR__ . '/views/options_departements.php');
                            ?>
                        </datalist>
                    </div>
                    <div class="form-group col-md-2 d-none" id="seller-choice">
                        <label for="statut">Statut</label>
                        <select class="form-control" name="statut" id="statut">
                            <option value="approche">Approche</option>
                            <option value="nego">Négociation</option>
                            <option value="mandatEnvoye">Mandat envoyé</option>
                            <option value="mandatSigne">Mandat signé</option>
                            <option value="vendu">Vendu</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary mt-3" id="add-location">Ajouter une localisation</button>    
                </div>
                <h5 class="mt-3" id="buyer-title">Intérêt</h5>
                <div class="row form-row mt-3" id="interest">
                    <div class="form-group col-md-2">
                        <label for="niveau">Niveau</label>
                        <select class="form-control" name="niveau" id="niveau">
                            <option value= null></option>
                            <option value="interesse">Intéressé</option>
                            <option value="NDAenvoye">NDA envoyé</option>
                            <option value="dossierEnvoye">Dossier envoyé</option>
                            <option value="LOI">LOI</option>
                            <option value="achat">Achat réalisé</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="villeInterest">Ville</label>
                        <input class="form-control" list="villesInterest" id="villeInterest" name="villeInterest">
                        <datalist id="villesInterest">
                            <?php
                                include(__DIR__ . '/views/options_villes.php');
                            ?>
                        </datalist>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="departementInterest">Département</label>
                        <input class="form-control" list="departementsInterest" id="departementInterest" name="departementInterest">
                        <datalist id="departementsInterest">
                            <?php
                                include(__DIR__ . '/views/options_departements.php');
                            ?>
                        </datalist>
                    </div>    
                    <div class="form-group col-md-3">
                        <label for="identifierInterest">Identifiant</label>
                        <input class="form-control" list="identifiersInterest" id="identifierInterest" name="identifierInterest">
                        <datalist id="identifierInterest">
                            <option value= null>
                            <option value="Consultation">
                        </datalist>
                    </div>
                    <button type="button" class="btn btn-secondary mt-3" id="add-interest">Ajouter un intérêt</button>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
            </form>
        </div>
    </div>
    <script src="js/form_contact.js" defer> </script>
</body>
</html>