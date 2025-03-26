<?php

class AjoutInteretDepartementController{

    private $interetDepartementManager;
    private $departementManager;

    public function __construct() {

        $this->interetDepartementManager = new InteretDepartementManager();
        $this->departementManager = new DepartementManager();

    }

    public function handleAjoutInteretDepartement(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $idContact = (int) $_POST["idContact"];
            
            $departement = $this-> sanitizeInput($_POST['departementInterest']);

            //si interetDepartement n'est pas vide, on l'ajoute
            if (!empty($_POST['departementInterest'])){
                $idDepartement = $this->departementManager->getDepartementIdByName($departement);

                $interetDepartement = new InteretDepartement([
                    'idContact' => $idContact,
                    'idDepartement' => $idDepartement
                ]);

                $result = $this->interetDepartementManager->insertInteretDepartement($interetDepartement);
               
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