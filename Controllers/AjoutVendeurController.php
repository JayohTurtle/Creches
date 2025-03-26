<?php

class AjoutVendeurController {
    private $localisationManager;
    private $groupeManager;
    private $clientManager;
    private $departementManager;
    private $villeManager;

    public function __construct() {
        $this->localisationManager = new LocalisationManager();
        $this->clientManager = new ClientManager();
        $this->groupeManager = new GroupeManager();
        $this->departementManager = new DepartementManager();
        $this->villeManager = new VilleManager();
    }

    public function handleAjoutVendeur() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Ajout du contact et récupération de son ID
            $idContact = ($_POST['idContact']);

            // Vérifier si une ville est renseignée avant d'ajouter une localisation et un point de location(liée au contact, à ville et à departement)            
            if (!empty($_POST['villeVendeur']) && array_filter($_POST['villeVendeur'])) {
                $idLocalisations = $this->addLocalisation($idContact);
                $this->addLocation($idLocalisations, $_POST['villeVendeur'], $_POST['codePostalVendeur'], $_POST['adresse']);
            }

            $this->addClient($idContact);

            unset($_SESSION['form_data']['contact']); 
            unset($_SESSION['form_data']['nom']);
            unset($_SESSION['form_data']['email']);
            unset($_SESSION['form_data']['siren']);
            unset($_SESSION['form_data']['telephone']);
            unset($_SESSION['form_data']['site']);
            unset($_SESSION['form_data']['comment']);  

            header("Location: index.php?action=newContact&success=1");
            exit();
        }
    }

    private function addLocalisation($idContact) {
        $nom = $this->sanitizeInput($_POST['nom'] ?? null);
        
        $groupe = new Groupe;
        $groupe->setNom($nom);
        $groupe->setIdContact($idContact);

        $idGroupe = $this->groupeManager->insertGroupe($groupe);
    
        $idLocalisations = [];
    
        if (!empty($_POST['villeVendeur'])) {

            $groupe = isset($_POST['groupe']) ? 1 : 0;
            $ventesSolo = $_POST['solo'] ?? []; // Tableau des checkboxes cochées "solo[]"

            foreach ($_POST['villeVendeur'] as $key => $ville) {
                $ville = $this->sanitizeInput($ville);
                $codePostal = $this->sanitizeInput($_POST['codePostalVendeur'][$key] ?? '');
                $adresse = $this->sanitizeInput($_POST['adresse'][$key] ?? '');
                $taille = $_POST['taille'][$key] ?? null;

                if ($groupe) {
                    $vente = 'groupe'; // Si "groupe" est coché, tout est "groupe"
                } else {
                    $vente = in_array($key + 1, $ventesSolo) ? 'groupe' : 'solo';
                }

                // Récupération des IDs nécessaires
                $idDepartement = $this->departementManager->getIdDepartementByCodePostal($codePostal);
                $idVille = $this->villeManager->insertVilleIfNotExists($ville, $codePostal, $idDepartement);
            
                // Création de l'identifiant
                $nom = $this->sanitizeInput($_POST['nom']);
                $identifiant = "$nom - $ville - $adresse";
            
                // Création de l'objet Localisation
                $localisation = new Localisation;
                $localisation->setIdContact($idContact);
                $localisation->setIdVille($idVille);
                $localisation->setIdDepartement($idDepartement);
                $localisation->setAdresse($adresse);
                $localisation->setIdentifiant($identifiant);
                $localisation->setTaille($taille);
                $localisation->setIdGroupe($idGroupe);
                $localisation->setVente($vente); // Vente = groupe ou solo
            
                // Insertion en base
                $idLocalisation = $this->localisationManager->insertLocalisation($localisation);
            
                if ($idLocalisation) {
                    $idLocalisations[] = $idLocalisation;
                }
            }
        }            

        return $idLocalisations;
    }
            
    private function addLocation($idLocalisations, $villes, $codesPostaux, $adresses) {
        if (!empty($idLocalisations)) {
            foreach ($idLocalisations as $key => $idLocalisation) {
                $ville = $villes[$key] ?? '';
                $codePostal = $codesPostaux[$key] ?? '';
                $adresse = $adresses[$key] ?? '';
    
                $adresseComplete = $this->localisationManager->createAddress($adresse, $codePostal, $ville);
    
                // Appel à geocodeAdresse
                $coords = $this->localisationManager->geocodeAdresse($adresseComplete);
                if ($coords) {
                    $latitude = $coords['lat'];
                    $longitude = $coords['lng'];
    
                    $this->localisationManager->insertLocation($idLocalisation, $latitude, $longitude);

                }
            }
        }
    }
    
    private function addClient($idContact){

        // Vérifier si la valorisation est un nombre, sinon mettre 0
        $valorisation = $this->sanitizeInput($_POST['valorisation'] ?? null);
        // Vérifier si la commission est un nombre, sinon mettre 0
        $commission = $this->sanitizeInput($_POST['commission'] ?? null);

        $client = new Client;
        $client->setIdContact($idContact);
        $client->setStatut($this->sanitizeInput(($_POST['statut'])));
        $client->setValorisation(is_numeric($valorisation) ? (int) $valorisation : 0);
        $client->setcommission(is_numeric($commission) ? (int) $commission : 0);

        $this->clientManager->insertClient($client);

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
