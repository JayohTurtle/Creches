<?php

class ActionContactController {

    private $contactManager;
    private $commentManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
        $this->commentManager = new CommentManager();

    }

    public function handleActionContact(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $emailsString = $_POST['emails'];
            $zoneValue = $_POST['zoneValue'];
            $zoneType = $_POST['zoneType'];
            $zoneVille = $_POST['zoneVille'];
            $nombreCreche = $_POST['nombreCreche'];
            $rayon = $_POST['rayon'];
        
            $emails = explode(',', $emailsString);

            $emails = array_map('trim', $emails);
        }

        $operateur = $_SESSION['userEmail'];
        $dateComment = date('Y-m-d');

        foreach ($emails as $email) {
            $idContact = $this->contactManager->getIdContactByEmail($email);

            $comment = new Comment ([
                'idContact' => $idContact,
                'commentaire' => "Prise de contact par mail",
                'operateur' => $operateur,
                'dateComment' => $dateComment
            ]);
           
            $this->commentManager->insertComment($comment);
        }

        $url = "index.php?action=resultZoneContact&zoneValue=" . urlencode($zoneValue) . "&nombreCreche=" . urlencode($nombreCreche) .  "&zoneType=" . urlencode($zoneType) .  "&zoneVille=" . urlencode($zoneVille) .  "&rayon=" . urlencode($rayon);

        header("Location: $url");
        exit();
    }
}