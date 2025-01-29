<?php
session_start();

require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/config/databaseconnect.php');


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
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'ville') === 0) {
            $ville = trim(strip_tags($value));
            
            $postalCodeKey = 'postalCode' . substr($key, 5); // Correction ici
            if (isset($_POST[$postalCodeKey])) {
                $postalCode = trim(strip_tags($_POST[$postalCodeKey]));
    
                $checkVille = $mysqlCreche->prepare('SELECT * FROM villes WHERE ville = :ville');
                $checkVille->execute(['ville' => $ville]);
    
                if (!$checkVille->rowCount() > 0) {
                    $insertVille = $mysqlCreche->prepare('INSERT INTO villes(ville, code_postal) VALUES (:ville, :postalCode)');
                    $insertVille->execute([
                        'ville' => $ville,
                        'postalCode' => $postalCode, // Correction ici
                    ]);
                }
            }
    
            $departementKey = 'departement' . substr($key, 5); // Correction ici
            if (isset($_POST[$departementKey])) {
                $departement = trim(strip_tags($_POST[$departementKey]));
                
                $checkDepartement = $mysqlCreche->prepare('SELECT * FROM departements WHERE departement = :departement');
                $checkDepartement->execute(['departement' => $departement]);
    
                if (!$checkDepartement->rowCount() > 0) {
                    $insertDepartement = $mysqlCreche->prepare('INSERT INTO departements (departement) VALUES (:departement)');
                    $insertDepartement->execute([
                        'departement' => $departement,
                    ]);
                }
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveaux contacts</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require_once(__DIR__ . '/header.php'); ?>
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
                            <option value= null>
                            <option value="Consultation">
                        </datalist>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="postalCode">Code postal</label>
                        <input class="form-control" list="postalCodes" id="postalCode" name="postalCode">
                        <datalist id="postalCodes">
                            <option value= null>
                            <option value="Consultation">
                        </datalist>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="departement">Département</label>
                        <input class="form-control" list="departements" id="departement" name="departement">
                        <datalist id="departements">
                            <option value= null>
                            <option value="Consultation">
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
                    <div class="form-group col-md-3">
                        <label for="villeInterest">Ville</label>
                        <input class="form-control" list="villesInterest" id="villeInterest" name="villeInterest">
                        <datalist id="villesInterest">
                            <option value= null>
                            <option value="Consultation">
                        </datalist>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="departementInterest">Département</label>
                        <input class="form-control" list="departementsInterest" id="departementInterest" name="departementInterest">
                        <datalist id="departementsInterest">
                            <option value= null>
                            <option value="Consultation">
                        </datalist>
                    </div>    
                    <div class="form-group col-md-3">
                        <label for="identifiantInterest">Identifiant</label>
                        <input class="form-control" list="identifiantsInterest" id="identifiantInterest" name="identifiantInterest">
                        <datalist id="identifiantsInterest">
                            <option value= null>
                            <option value="Consultation">
                        </datalist>
                    </div>
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
                    <button type="button" class="btn btn-secondary mt-3" id="add-interest">Ajouter un intérêt</button>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
            </form>
        </div>
    </div>
    <script src="js/script.js" defer> </script>
</body>
</html>