<?php

class AddInteretCrecheController{

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

    public function handleAddInteretCreche (){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idContact = (int) $_POST["idContact"];
            $niveau = $this->sanitizeInput($_POST['niveauInteret'] ?? '');
            $identifiant = $this->sanitizeInput($_POST['interetCreche'] ?? '');
            $identifiant = str_replace("’", "'", $identifiant);
            $groupe = $this->sanitizeInput($_POST['interetGroupe'] ?? '');

            //si interetCreche n'est pas vide, on l'ajoute
            if (!empty($_POST['interetCreche'])){

                if (!$identifiant) {
                    echo json_encode(['error' => 'Identifiant manquant']);
                    exit;
                }

                $localisationManager = new LocalisationManager();
                $localisationId = $localisationManager->getLocalisationIdByIdentifiant($identifiant);

                $result = $this->interetCrecheManager->insertInteretCreche($idContact, $niveau, $localisationId);

                if ($result) {
                // Réponse en cas de succès
                    echo json_encode(['status' => 'success', 'message' => 'Interet ajouté avec succès']);
                } else {
                    // Si l'insertion a échoué
                    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout de l\'intérêt']);
                }
                exit;
            }

            if (!empty($_POST['interetGroupe'])){
                $result = $this->interetGroupeManager->insertInteretGroupe($idContact, $niveau, $groupe);

                if ($result) {
                    // Réponse en cas de succès
                    echo json_encode(['status' => 'success', 'message' => 'Interet ajouté avec succès']);
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