<?php

class ModifCommissionController {

    private $clientManager;

    public function __construct() {
        $this->clientManager = new ClientManager();
    }

    public function handleModifCommission() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idContact = (int) $_POST["idContact"];
            $commission = $_POST["infoCommission"];
    
            $result = $this->clientManager->modifCommission($idContact, $commission);

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