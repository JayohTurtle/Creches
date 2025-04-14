<?php

class EventsController {
    
    private $eventManager;

    public function __construct() {
        $this->eventManager = new EventManager();
    }

    public function showEvents() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $events = $this->eventManager->getAllEvents();
        }

        // Passer toutes les données à la vue
        $view = new View();
        $view->render('events', [
            'events' => $events
        ]);
    }

    public function addEvent() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $event = new Event();
            $event->setTitle($_POST['title']);
            $event->setStart($_POST['start']);
            $event->setLocation($_POST['location']);
            $event->setDescription($_POST['description']);

            $this->eventManager->insertEvent($event);
        }

        // Rediriger vers la page des événements après l'ajout
        header("Location: index.php?action=events");
        exit;
    }

    public function deleteEvent($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->eventManager->deleteEvent($id);
        }

        // Rediriger vers la page des événements après la suppression
        header("Location: index.php?action=events");
        exit;
    }

    public function updateEvent($id) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $event = new Event();
            $event->setIdEvent($id);
            $event->setTitle($_POST['title']);
            $event->setStart($_POST['start']);
            $event->setLocation($_POST['location']);
            $event->setDescription($_POST['description']);

            $this->eventManager->updateEvent($event);
        }

        // Rediriger vers la page des événements après la mise à jour
        header("Location: index.php?action=events");
        exit;
    }

    public function getEvent($id) {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $event = $this->eventManager->getEventById($id);
        }

        // Passer toutes les données à la vue
        $view = new View();
        $view->render('event', [
            'event' => $event
        ]);
    }
}