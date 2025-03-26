<?php

class AjoutInteretFranceController{

    private $interetFranceManager;


    public function __construct() {

        $this->interetFranceManager = new InteretFranceManager();

    }

    public function handleAjoutInteretFrance(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $idContact = (int) $_POST["idContact"];

            $result = $this->interetFranceManager->insertInteretFrance($idContact);
               
            if ($result) {
            // Réponse en cas de succès
                echo json_encode(['status' => 'success', 'message' => 'Interet ajouté avec succès']);
                exit;
            } else {
                // Si l'insertion a échoué
                echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de l\'intérêt']);
            }
        }
    }

    /**
     * Fonction utilitaire pour nettoyer les entrées utilisateur destinées à la base de données.
     */
    private function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input); // Nettoie les entrées dans les tableaux
        }
        return trim($input); // Supprime simplement les espaces inutiles
    }
}