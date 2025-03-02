<?php

class AddInteretGeneralController{

    private $interetVilleManager;
    private $interetDepartementManager;
    private $interetRegionManager;
    private $villeManager;
    private $departementManager;
    private $regionManager;

    public function __construct() {

        $this->interetVilleManager = new InteretVilleManager();
        $this->interetDepartementManager = new InteretDepartementManager();
        $this->interetRegionManager = new InteretRegionManager();
        $this->villeManager = new VilleManager();
        $this->departementManager = new DepartementManager();
        $this-> regionManager = new RegionManager();

    }

    public function handleAddInteretGeneral(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $idContact = (int) $_POST["idContact"];
            $ville = $this-> sanitizeInput($_POST['villeInterest']);
            $codePostal = $this-> sanitizeInput($_POST['codePostalInterest']);
            $rayon = $this-> sanitizeInput($_POST['rayonInterest']);
            $departement = $this-> sanitizeInput($_POST['departementInterest']);
            $region = $this-> sanitizeInput($_POST['regionInterest']);

            //si interetVille n'est pas vide, on l'ajoute
            if (!empty($_POST['villeInterest'])){
                $idDepartement = $this->departementManager->getDepartementIdByCodePostal($codePostal);
                $idVille = $this->villeManager->insertVilleIfNotExists($ville, $codePostal, $idDepartement);
                $result = $this->interetVilleManager->insertInteretVille($idContact, $idVille, $rayon);
               
               if ($result) {
                // Réponse en cas de succès
                    echo json_encode(['status' => 'success', 'message' => 'Interet ajouté avec succès']);
                    exit;
                } else {
                    // Si l'insertion a échoué
                    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de l\'intérêt']);
                }
            }
            //si interetDepartement n'est pas vide, on l'ajoute
            if (!empty($_POST['departementInterest'])){
                $idDepartement = $this->departementManager->getDepartementIdByName($departement);
                $result = $this->interetDepartementManager->insertInteretDepartement($idContact, $idDepartement);
               
               if ($result) {
                // Réponse en cas de succès
                    echo json_encode(['status' => 'success', 'message' => 'Interet ajouté avec succès']);
                    exit;
                } else {
                    // Si l'insertion a échoué
                    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de l\'intérêt']);
                }
            }

            //si interetRegion n'est pas vide, on l'ajoute
            if (!empty($_POST['regionInterest'])){
                $idRegion = $this->regionManager->getRegionIdByName($region);
                $result = $this->interetRegionManager->insertInteretRegion($idContact, $idRegion);
               
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