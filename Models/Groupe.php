<?php

include_once('AbstractEntity.php');

class Groupe extends AbstractEntity{

    private $idGroupe;
    private $idContact;
    private $groupe;

    public function setIdGroupe(int $idGroupe):void{
        $this -> idGroupe = $idGroupe;
    }

    public function getidGroupe ():int{
        return $this -> idGroupe;
    }

    public function setIdContact (int $idContact){
        $this -> idContact = $idContact;
    }

    public function getIdContact ():int{
        return $this -> idContact;
    }

    public function setGroupe (string $groupe){
        $this -> groupe = $groupe;
    }

    public function getGroupe ():string{
        return $this -> groupe;
    }
}