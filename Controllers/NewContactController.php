<?php

class NewContactController {

    public function showNewContact() {

        $view = new View();
        $view->render('newContact', [
        ]);
    }
}
