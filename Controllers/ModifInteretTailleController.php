<?php

class ModifInteretTailleController {

    private $interetTailleManager;

    public function __construct() {
        $this->interetTailleManager = new InteretTailleManager();
    }

    public function handleModifInteretTaille() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idContact = (int) $_POST["idContact"];
            $taille = $_POST["taille"];
    
            $resultat = $this->interetTailleManager->verifierEtMettreAJourTaille($idContact, $taille);

            echo json_encode($resultat);
            exit;


        }
    }
    public function handleConfirmationModificationInteretTaille() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!isset($_POST["idContact"], $_POST["valeur"])) {
                echo json_encode(["status" => "error", "message" => "Données incomplètes"]);
                exit;
            }
    
            $idContact = (int) $_POST["idContact"];
            $valeur = $_POST["valeur"];
    
            $this->interetTailleManager->mettreAJourInteretTaille($idContact, $valeur);
    
            echo json_encode(["status" => "success"]);
            exit;
        }
    }

}