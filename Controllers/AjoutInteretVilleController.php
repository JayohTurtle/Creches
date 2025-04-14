<?php

class AjoutInteretVilleController{

    private $interetVilleManager;
    private $villeManager;
    private $departementManager;


    public function __construct() {

        $this->interetVilleManager = new InteretVilleManager();
        $this->villeManager = new VilleManager();
        $this->departementManager = new DepartementManager();
    }

    public function handleAjoutInteretVille(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $idContact = (int) $_POST["idContact"];
            $ville = $this-> sanitizeInput($_POST['villeInterest']);
            $codePostal = $this-> sanitizeInput($_POST['codePostalInterest']);
            $rayon = $this-> sanitizeInput($_POST['rayonInterest']);

            if ($rayon === "") {
                $rayon = 5; // Si le rayon est vide, on le met à 5
            } else {
                $rayon = (int) $rayon; // Sinon, on le convertit en entier
            }

            //si interetVille n'est pas vide, on ajoute la ville si elle n'existe pas et on ajoute l'intérêt
            if (!empty($_POST['villeInterest'])){
                $idDepartement = $this->departementManager->getDepartementIdByCodePostal($codePostal);
                $idVille = $this->villeManager->insertVilleIfNotExists($ville, $codePostal, $idDepartement);
                $interetVille = new InteretVille ([
                    'idContact' => $idContact,
                    'idVille' => $idVille,
                    'rayon' => $rayon
                ]);

                $result = $this->interetVilleManager->insertInteretVille($interetVille);
               
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
