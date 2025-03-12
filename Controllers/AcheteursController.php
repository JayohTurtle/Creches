
<?php

class AcheteursController {
    private $contactManager;
    private $localisationManager;
    private $clientManager;
    private $villeManager;
    private $departementManager;
    private $regionManager;
    private $interetCrecheManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
        $this->localisationManager = new LocalisationManager();
        $this->clientManager = new ClientManager();
        $this->villeManager = new VilleManager();
        $this->departementManager = new DepartementManager();
        $this->regionManager = new RegionManager();
        $this->interetCrecheManager = new InteretCrecheManager();
    }

    public function showAcheteurs() {
        $contacts = $this->contactManager->getAcheteursContacts();
        $localisations = $this->localisationManager->getLocalisations();
        $villes = $this->villeManager->getVilles();
        $departements = $this->departementManager->getDepartements();
        $regions = $this->regionManager->getRegions();

        // Récupération des données depuis interetCreche
        $interetsCrecheData = $this->interetCrecheManager->getCrecheData();   

        // S'assurer de la correspondance des statuts
        $niveauMapping = [
            "Intéressé" => "interesses",
            "NDA envoyé" => "nda_envoyes",
            "NDA signé" => "nda_signes",
            "Dossier envoyé" => "dossiers_envoyes",
            "LOI" => "sous_offres",
            "Vendu" => "vendus"
        ];

        // Initialisation des compteurs
        $nbParNiveau = [
            "interesses" => ["nbInterets" => 0, "nbContacts" => 0, "contacts_uniques" => []],
            "nda_envoyes" => ["nbInterets" => 0, "nbContacts" => 0, "contacts_uniques" => []],
            "nda_signes" => ["nbInterets" => 0, "nbContacts" => 0, "contacts_uniques" => []],
            "dossiers_envoyes" => ["nbInterets" => 0, "nbContacts" => 0, "contacts_uniques" => []],
            "sous_offres" => ["nbInterets" => 0, "nbContacts" => 0, "contacts_uniques" => []],
            "vendus" => ["nbInterets" => 0, "nbContacts" => 0, "contacts_uniques" => []],
        ];

        // Parcours des données crèche et récupération des niveaux associés
        foreach ($interetsCrecheData as $crecheData) {
            $idContact = $crecheData["idContact"];
            $niveau = $crecheData["niveau"];

            // Vérifier si le niveau existe dans le mapping
            if (isset($niveauMapping[$niveau])) {
                $niveauCorrect = $niveauMapping[$niveau];

                // Initialiser le niveau s'il n'existe pas encore
                if (!isset($nbParNiveau[$niveauCorrect]["contacts_uniques"])) {
                    $nbParNiveau[$niveauCorrect]["contacts_uniques"] = []; // Initialise un tableau vide
                }

                // Incrémenter le nombre total d'intérêts pour ce niveau
                $nbParNiveau[$niveauCorrect]["nbInterets"]++;

                // Si l'idContact n'est pas encore compté, l'ajouter et incrémenter le compteur unique
                if (!in_array($idContact, $nbParNiveau[$niveauCorrect]["contacts_uniques"])) {
                    $nbParNiveau[$niveauCorrect]["contacts_uniques"][] = $idContact;
                    $nbParNiveau[$niveauCorrect]["nbContacts"]++;
                }
            }
        }

        // Suppression des clés "contacts_uniques" (optionnel si tu n'en as plus besoin)
        foreach ($nbParNiveau as &$niveauData) {
            unset($niveauData["contacts_uniques"]);
        }

        // Préparer les données pour la vue
        $groupes = [];
        foreach ($nbParNiveau as $niveau => $data) {
            if ($data["nbContacts"] > 0) { // On ne garde que les niveaux avec des contacts
                $groupes[$niveau] = [
                    "acheteurs" => $data["nbContacts"], // Nombre d'acheteurs
                    "nom" =>  $niveau,
                    "creches" => $data["nbInterets"] // Nombre total d'intérêts
                ];
            }
        }

        // Passer toutes les données à la vue
        $view = new View();
        $view->render('acheteurs', [
            'contacts' => $contacts,
            'localisations' => $localisations,
            'villes' => $villes,
            'departements' => $departements,
            'regions' => $regions,
            'groupes' => $groupes, // Passage des groupes à la vue
            'niveauMapping' =>$niveauMapping
        ]);
    }
}


