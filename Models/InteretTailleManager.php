<?php

include_once('AbstractEntityManager.php');

class InteretTailleManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec les id ville et contact
    public function insertInteretTaille($idContact, $taille) {
        $sql = 'INSERT INTO interettaille (idContact, taille) 
                VALUES (:idContact, :taille)';
        return $this->db->query($sql, [
            'idContact' => $idContact,
            'taille' => $taille
        ]);
    }
}
