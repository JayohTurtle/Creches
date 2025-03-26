<?php

class AjoutInteretRegionController{

    private $interetRegionManager;
    private $regionManager;

    public function __construct() {

        $this->interetRegionManager = new InteretRegionManager();
        $this-> regionManager = new RegionManager();

    }

    public function handleAjoutInteretRegion(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $idContact = (int) $_POST["idContact"];
            $region = $this-> sanitizeInput($_POST['regionInterest']);

            //si interetRegion n'est pas vide, on l'ajoute
            if (!empty($_POST['regionInterest'])){
                $idRegion = $this->regionManager->getRegionIdByName($region);

                $interetRegion = new InteretRegion([
                    'idContact' => $idContact,
                    'idRegion' => $idRegion
                ]);

                $result = $this->interetRegionManager->insertInteretRegion($interetRegion);
               
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