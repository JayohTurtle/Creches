<?php

class AjoutInfoContactController {

    private $contactManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
    }

    public function handleAjoutInfoContact() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idContact = (int) $_POST["idContact"];
            $champ = $_POST["champ"];
            $valeur = $_POST["valeur"];
    
            $resultat = $this->contactManager->verifierEtMettreAJourContact($idContact, $champ, $valeur);
            
            echo json_encode($resultat);
            exit;
        }
    }

    public function handleConfirmationModificationContact() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST["idContact"], $_POST["champ"], $_POST["valeur"])) {
                echo json_encode(["status" => "error", "message" => "Données incomplètes"]);
                exit;
            }
    
            $idContact = (int) $_POST["idContact"];
            $champ = $_POST["champ"];
            $valeur = $_POST["valeur"];
    
            $this->contactManager->mettreAJourContact($idContact, $champ, $valeur);
    
            echo json_encode(["status" => "success"]);
            exit;
        }
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