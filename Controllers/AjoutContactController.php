<?php

class AjoutContactController {
    private $contactManager;
    private $commentManager;
    private $departementManager;
    private $regionManager;
    private $groupeManager;
    private $localisationManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
        $this->commentManager = new CommentManager();
        $this->departementManager = new DepartementManager();
        $this->regionManager = new RegionManager();
        $this->groupeManager = new GroupeManager();
        $this->localisationManager = new LocalisationManager();
    }

    public function handleAjoutContact() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $operateur = $_SESSION['userEmail'];

            $_SESSION['form_data'] = $_POST;

            // Ajout du contact et récupération de son ID
            $idContact = $this->addContact();

            // Ajout du commentaire (liée au contact)
            $this->addComment($operateur, $idContact);

            // Récupération des données nécessaires pour le formulaire
            $departements = $this->departementManager->getDepartements();
            $regions = $this->regionManager->getRegions();
            $localisations = $this->localisationManager->getLocalisationsAVendre();
            $groupes = $this->groupeManager->getGroupesAVendre();

            // Redirection après ajout
            if ($_POST['sens'] === 'Acheteur' || $_POST['sens'] === 'Neutre'){
                // Passer toutes les données à la vue
                $view = new View();
                $view->render('newAcheteur', [
                    'idContact' => $idContact,
                    'nom' => $_POST['nom'],
                    'sens'=> $_POST['sens'],
                    'localisations' => $localisations,
                    'departements' => $departements,
                    'regions' => $regions,
                    'groupes' => $groupes,
                    'success' => true
                ]);
            }

            // Redirection après ajout
            if ($_POST['sens'] === 'Vendeur'){
                // Passer toutes les données à la vue
                $view = new View();
                $view->render('newVendeur', [
                    'idContact' => $idContact,
                    'nom' => $_POST['nom'],
                    'success' => true
                ]);
            }
        }
    }

    private function addContact() {

        $nom = $this->sanitizeInput($_POST['nom'] ?? null);
        $contact = $this->sanitizeInput($_POST['contact'] ?? null);
        $email = $this->sanitizeInput($_POST['email'] ?? null);
        
        if ($this->contactManager->contactExists($nom, $contact, $email)) {
            // Redirection avec un message d'erreur
            header("Location: index.php?action=newContact&error=contact_existe");
            exit();
        }
        
        $contact = new Contact();
        $contact->setNom($this->sanitizeInput(($_POST['nom']?? null)));
        $contact->setContact($this->sanitizeInput(($_POST['contact']?? null)));
        $contact->setSiren($this->sanitizeInput(($_POST['siren']?? null)));
        $contact->setEmail($this->sanitizeInput(($_POST['email']?? null)));
        $contact->setTelephone($this->sanitizeInput(($_POST['telephone']?? null)));
        $contact->setSiteInternet($this->sanitizeInput(($_POST['site']?? null)));
        $contact->setSens($this->sanitizeInput(($_POST['sens'])));

        return $this->contactManager->insertContact($contact);
            
    }
    
    private function addComment($operateur, $idContact) {
        if (!empty($_POST['comment'])) {
            $comment = new Comment();
            $comment->setIdContact($idContact);
            $comment->setCommentaire($this->sanitizeInput(($_POST['comment'])));
            $comment->setDateComment(date("Y/m/d"));
            $comment->setOperateur($operateur);

            $this->commentManager->insertComment($comment);
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