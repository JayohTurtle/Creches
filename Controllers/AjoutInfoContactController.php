<?php

class AjoutInfoContactController {

    private $contactManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
    }

    public function handleInfoContact() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idContact = (int) $_POST["idContact"];
    
            // ⚡️ L'utilisateur a confirmé les modifications
            if (!empty($_POST["confirm"]) && $_POST["confirm"] === "true") {

            // Supprimer "confirm" pour éviter de l'envoyer en SQL
            unset($_POST["confirm"]);
            $this->contactManager->confirmerUpdateContact($idContact, $_POST);
            echo json_encode(["status" => "success"]);
            exit();
            }
    
            // ⚡️ Préparation des modifications
            $champs = ["infoContact", "infoNomGroupe", "infoSIREN", "infoEmail", "infoTelephone", "infoSens", "infoSite"];
 
            $infosContact = [];
    
            foreach ($champs as $champ) {
                if (!empty($_POST[$champ])) {
                    $infosContact[$champ] = htmlspecialchars(trim($_POST[$champ]));
                }
            }
    
            if (empty($infosContact)) {
                echo json_encode(["status" => "error", "message" => "Aucune information renseignée."]);
                exit();
            }
    
            // ✅ Appliquer le MAPPING avant la comparaison avec la BDD
            $mapping = [
                "infoContact"   => "contact",
                "infoNomGroupe" => "nom",
                "infoSIREN"     => "siren",
                "infoEmail"     => "email",
                "infoTelephone" => "telephone",
                "infoSens"      => "sens",
                "infoSite"      => "siteInternet"
            ];
    
            $infosContactMapped = [];
            foreach ($infosContact as $key => $value) {
                if (isset($mapping[$key])) {
                    $infosContactMapped[$mapping[$key]] = $value;
                }
            }
    
            // 🔥 Comparaison avec la BDD
            $modifications = $this->contactManager->updateContact($idContact, $infosContactMapped);

            if ($modifications["status"] === "no_change") {
                echo json_encode(["status" => "success"]);
                exit();
            }

            // ✅ Vérification : faut-il une confirmation ?
            $confirmationRequise = false;
            foreach ($modifications["modifications"] as $champ => $modif) {
                if (!empty($modif["ancien"])) {  // S'il y avait déjà une valeur en BDD, on demande confirmation
                    $confirmationRequise = true;
                    break;
                }
            }

            if (!$confirmationRequise) {
                // 💾 Appliquer directement la mise à jour sans confirmation
                $this->contactManager->confirmerUpdateContact($idContact, $infosContactMapped, $modifications["contactActuel"]);
                echo json_encode(["status" => "success"]);
                exit();
            }

            // ❗ Sinon, on demande confirmation
            echo json_encode([
                "status" => "confirm_required",
                "modifications" => $modifications["modifications"],
                "idContact" => $idContact
            ]);
            exit();
        }

    }
    
    public function confirmUpdateContact($infosContact, $idContact) {
        // Vérifier si des données sont présentes
        if (empty($infosContact)) {
            echo json_encode(["status" => "error", "message" => "Aucune mise à jour effectuée."]);
            exit();
        }
    
        // Exécuter la mise à jour dans ContactManager
        $this->contactManager->confirmerUpdateContact($idContact, $infosContact);
    
        // Retourner une réponse JSON de succès
        echo json_encode(["status" => "success"]);
        exit();
    }
    
    public function addInfoContact(array $infosContact, $idContact){
        $champsAChanger = $this->contactManager->updateContact($idContact, $infosContact);
    
        if (is_string($champsAChanger)) {
            echo json_encode(["status" => "error", "message" => $champsAChanger]);
            exit();
        }
    
        // Retourner les champs modifiés sous forme JSON pour affichage dans le popup
        echo json_encode([
            "status" => "success",
            "modifications" => $champsAChanger,
            "idContact" => $idContact,
            "infosContact" => $infosContact
        ]);
        exit();
    }

    /**
     * Fonction utilitaire pour nettoyer les entrées utilisateur destinées à la base de données.
     */
    public function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input); // Nettoie les entrées dans les tableaux
        }
        return trim($input); // Supprime simplement les espaces inutiles
    }

}