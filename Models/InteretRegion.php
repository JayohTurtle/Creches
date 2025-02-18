<?php

include_once('AbstractEntity.php');

class InteretRegion extends AbstractEntity{

    private $idInteretRegion;
    private $idContact;
    private $idRegion;
    private $region;

    public function setIdInteretRegion(int $idInteretRegion):void{
        $this -> idInteretRegion = $idInteretRegion;
    }

    public function getIdInteretRegion ():int{
        return $this -> idInteretRegion;
    }

    public function setIdContact (int $idContact){
        $this -> idContact = $idContact;
    }

    public function getIdContact ():int{
        return $this -> idContact;
    }

    public function setIdRegion (?int $idRegion){
        $this -> idRegion = $idRegion;
    }

    public function getIdRegion ():?int{
        return $this -> idRegion;
    }

    public function setRegion (Region $region){
        $this -> region = $region;
    }

    public function getRegion ():Region{
        return $this -> region;
    }
}