<?php

include_once('AbstractEntity.php');

class InteretDepartement extends AbstractEntity{

    private $idInteretDepartement;
    private $idContact;
    private $idDepartement;

    public function setIdInteretDepartement(int $idInteretDepartement):void{
        $this -> idInteretDepartement = $idInteretDepartement;
    }

    public function getIdInteretDepartement ():int{
        return $this -> idInteretDepartement;
    }

    public function setIdContact (int $idContact){
        $this -> idContact = $idContact;
    }

    public function getIdContact ():int{
        return $this -> idContact;
    }

    public function setIdDepartement (?int $idDepartement){
        $this -> idDepartement = $idDepartement;
    }

    public function getIdDepartement ():?int{
        return $this -> idDepartement;
    }
}