<?php

class AjoutInteretCrecheController{

    private $contactManager;
    private $interetCrecheManager;
    private $interetGroupeManager;
    private $localisationManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
        $this->interetCrecheManager = new InteretCrecheManager();
        $this->interetGroupeManager = new InteretGroupeManager();
        $this->localisationManager = new LocalisationManager();

    }

    public function handleAjoutInteretCreche (){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idContact = (int) $_POST["idContact"];
            $niveau = $this->sanitizeInput($_POST['niveauInteret'] ?? '');
            $identifiant = $this->sanitizeInput($_POST['interetCreche'] ?? '');
            $identifiant = str_replace("’", "'", $identifiant);

            //si interetCreche n'est pas vide, on l'ajoute
            if (!empty($_POST['interetCreche'])){

                if (!$identifiant) {
                    echo json_encode(['error' => 'Identifiant manquant']);
                    exit;
                }

                $localisationManager = new LocalisationManager();
                $idLocalisation = $localisationManager->getIdLocalisationByIdentifiant($identifiant);

                $interetCreche = new InteretCreche([
                    'idContact' => $idContact,
                    'niveau' => $niveau,
                    'idLocalisation'=> $idLocalisation
                ]);

                $result = $this->interetCrecheManager->insertInteretCreche($interetCreche);

                if ($result) {
                // Réponse en cas de succès
                    echo json_encode(['status' => 'success', 'message' => 'Interet ajouté avec succès']);
                } else {
                    // Si l'insertion a échoué
                    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de l\'intérêt']);
                }
                exit;
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