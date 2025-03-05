<?php

class DashboardController {

    private $clientManager;
    private $localisationManager;

    public function __construct() {
        $this->clientManager = new ClientManager();
        $this->localisationManager = new LocalisationManager();
    }

    public function showDashBoard(){
        $clientsData = $this->clientManager->getDataClients();
    
        // Récupérer tous les idContact pour compter les crèches à vendre
        $idContacts = array_map(fn($client) => $client->getIdContact(), $clientsData);
        $nbCrechesAVendre = $this->localisationManager->countCrechesAVendre($idContacts);
    
        // Calculer la somme des commissions
        $totalCommission = array_sum(array_map(fn($client) => $client->getCommission(), $clientsData));
    
        // Envoyer les données à la vue
        $view = new View();
        $view->render("dashboard", [
            'nbCrecheAvendre' => $nbCrechesAVendre,
            'totalCommission' => $totalCommission
        ]);
    }
    
}


?>