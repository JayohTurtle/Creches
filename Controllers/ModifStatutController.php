<?php

class ModifStatutController {

    private $clientManager;

    public function __construct() {
        $this->clientManager = new ClientManager();
    }

    public function handleModifStatut() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $idContact = (int) $_POST["idContact"];
            $statut = $_POST["infoStatut"];
    
            $result = $this->clientManager->modifStatut($idContact, $statut);

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