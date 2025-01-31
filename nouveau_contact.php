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
    $siren = trim(strip_tags($postData['siren']));
    $email = trim(strip_tags($postData['email']));
    $telephone = trim(strip_tags($postData['telephone']));
    $sens = trim(strip_tags($postData['directionChoice']));
    $comment = trim(strip_tags($postData['comment']));
    $dateJour = date("Y/m/d");

    // On vérifie qu'il y a un commentaire
    if (isset($_POST['comment']) && (!empty($_POST['comment']))) {
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

    //On regarde si le contact existe déjà dans la base de données
    //on vérifie que le contact n'est pas vide
    if (!empty($_POST['contact'])){
        $checkContact = $mysqlCreche->prepare('SELECT * FROM contacts WHERE contact = :contact AND email = :email');
        $checkContact->execute([
            'contact' => $contact,
            'email' => $email,
        ]);

        //Si le contact n'existe pas, on l'ajoute
        if (!$checkContact->rowCount() > 0) {
            //on entre le contact dans la base de données
            $insertContact = $mysqlCreche->prepare('INSERT INTO contacts(nom, contact, siren, email, telephone, sens) VALUES (:nom, :contact, :siren, :email, :telephone, :sens)');

            $insertContact->execute([
                'nom' => $nom,
                'contact' => $contact,
                'siren' => $siren,
                'email' => $email,
                'telephone' => $telephone,
                'sens' => $sens
        ]);
        }
    }

    //on ajoute la ville, le code postal et le département
    //Comme il peut y'avoir plusieurs lignes on boucle sur les input
    //on vérifie que la ville n'est pas vide
    if (!empty($_POST['ville'])){
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
    }
    //on ajoute les intérêts
    //on vérifie que la ville ou le département ne sont pas vides
    if (!empty($_POST['villeInterest']) || (!empty($_POST['departementInterest']))){
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'niveau') === 0) {
                $niveau = trim(strip_tags($value));
        
                $villeInterestKey = 'villeInterest' . substr($key, 6); // 6 correspond à la longueur de 'niveau'
                $postalCodeInterest = 'postalCodeInterest'. substr($key, 6);
                $rayonInterest = 'rayonInterest'. substr($key, 6);
                $departementInterestKey = 'departementInterest' . substr($key, 6); // 6 correspond à la longueur de 'niveau'
                $identifierKey = 'identifierInterest' . substr($key, 6); // 6 correspond à la longueur de 'niveau'
        
                $villeInterest = isset($_POST[$villeInterestKey]) ? trim(strip_tags($_POST[$villeInterestKey])) : '';
                $postalCodeInterest = isset($_POST[$postalCodeInterestKey]) ? trim(strip_tags($_POST[$postalCodeInterestKey])) : '';
                $rayonInterest = isset($_POST[$rayonInterestKey]) ? trim(strip_tags($_POST[$rayonInterestKey])) : '';
                $departementInterest = isset($_POST[$departementInterestKey]) ? trim(strip_tags($_POST[$departementInterestKey])) : '';
                $identifier = isset($_POST[$identifierKey]) ? trim(strip_tags($_POST[$identifierKey])) : '';
        
                $insertInterest = $mysqlCreche->prepare('INSERT INTO interet (niveau, contact, ville, code_postal, rayon, departement, identifiant) VALUES (:niveau, :contact, :ville, :code_postal, :rayon, :departement, :identifiant)');
                $insertInterest->execute([
                    'niveau' => $niveau,
                    'contact' => $contact,
                    'ville' => $villeInterest,
                    'code_postal' => $postalCodeInterest,
                    'rayon' => $rayonInterest,
                    'departement' => $departementInterest,
                    'identifiant' => $identifier
                ]);
            }
        }
    }
}

require_once(__DIR__ . '/views/nouveau_contact_view.php'); 