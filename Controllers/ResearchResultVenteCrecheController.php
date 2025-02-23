<?php

class ResearchResultVenteCrecheController{

    private $localisationManager;
    private $contactManager;
    private $villeManager;
    private $departementManager;
    private $regionManager;

    public function __construct() {
        $this->villeManager = new VilleManager;
        $this->departementManager = new DepartementManager;
        $this->localisationManager = new LocalisationManager();
        $this->contactManager = new ContactManager();
        $this->regionManager = new RegionManager();
    }

    public function showResultVenteCreche() {

         // Stoppe l'exécution ici pour tester
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $zoneType = $_POST['localResearch'] ?? null;
            $zoneValue = null;
            $idDepartementList = [];

            // Vérifier quel input a été rempli selon le bouton radio sélectionné
            if ($zoneType === "researchVille") {
                $zoneVille = $this->sanitizeInput($_POST['zoneVille'] ?? null);
                $rayon = (int) $this->sanitizeInput($_POST['zoneVilleRayon'] ?? null);
                $zoneValue = 'Recherche dans un rayon de ' . $rayon . ' kms autour de ' . $zoneVille;
                
            } elseif ($zoneType === "researchDepartement") {
                $zoneValue = $this->sanitizeInput($_POST['zoneDepartement'] ?? null);
            } elseif ($zoneType === "researchRegion") {
                $zoneValue = $this->sanitizeInput($_POST['zoneRegion'] ?? null);
            }

            // Vérifier quel type de recherche est sélectionné
            switch ($zoneType) {
                case 'researchVille':
                    $coords = $this->villeManager->getCoordsByName($zoneVille);
                    if (!$coords) {
                        die("Erreur : Ville introuvable.");
                    }
                    break;
                case 'researchDepartement':
                    $idZone = $this->departementManager->getDepartementIdByName($zoneValue);
                    break;
                case 'researchRegion':
                    $idRegion = $this->regionManager->getRegionIdByName($zoneValue);
                    break;
                default:
                    die("Type de recherche invalide.");
            }

            // Récupérer les vendeurs
            $vendeurs = $this->contactManager->getVendeurs();
            
            // Extraire les ID des vendeurs
            $idVendeurs = array_map(fn($v) => $v->getIdContact(), $vendeurs);

            // Vérifier quel type de recherche est sélectionné
            switch ($zoneType) {
                case 'researchVille':
                    // Récupérer les objets Localisation contenant les identifiants
                   $localisationContacts = $this->localisationManager->getLocalisationsInRayon($coords, $rayon);
                   $localisations = $this->contactManager->comparerContacts($localisationContacts, $idVendeurs);
                   break;
                case 'researchDepartement':
                    // Récupérer les objets Localisation contenant les identifiants
                    $localisations = $this->localisationManager->getLocalisationsByVendeurAndDepartement($idVendeurs, $idZone);
                    break;
                case 'researchRegion':
                    $idDepartementList = $this->departementManager->getDepartementsIdByIdRegion($idRegion);

                    $idDepartementArray = [];
                    foreach ($idDepartementList as $dep) {
                        if (!$dep instanceof Departement) {
                            var_dump($dep);
                            die("🚨 Erreur : un élément de idDepartementList n'est pas un objet Departement !");
                        }
                        $idDepartementArray[] = $dep->getIdDepartement();
                    }

                    $localisations = $this->localisationManager->getLocalisationsByVendeurAndRegion($idVendeurs, $idDepartementArray);
                    break;

            }
            
            $identifiants = [];

            foreach ($localisations as $localisation) {
                $distance = ($zoneType === 'researchVille') ? $localisation->getDistance() : null; // ✅ Distance uniquement pour les villes
                $identifiants[] = [
                    'localisation' => $localisation,
                    'distance' => !is_null($distance) ? round($distance, 2) : null
                ];
            }
            
        }
         // Passer les résultats à la vue
         $view = new View();
         $view->render('researchResultZoneVente', [
             'identifiants' => $identifiants,
             'zoneValue' => $zoneValue ?? '',
             'rayon' => $rayon ?? null
         ]);
    }
               
    /** 
     * Fonction utilitaire pour nettoyer les entrées utilisateur.
     */
    private function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
}