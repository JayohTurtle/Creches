<?php

include_once('AbstractEntity.php');

class InteretFrance extends AbstractEntity{

    private $idInteretFrance;
    private $idContact;


    public function setIdInteretFrance(int $idInteretFrance):void{
        $this -> idInteretFrance = $idInteretFrance;
    }

    public function getIdInteretFrance ():int{
        return $this -> idInteretFrance;
    }

    public function setIdContact (int $idContact){
        $this -> idContact = $idContact;
    }

    public function getIdContact ():int{
        return $this -> idContact;
    }
}