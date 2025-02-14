<?php

include_once('AbstractEntity.php');

class Region extends AbstractEntity{

    private $idRegion;
    private $region;

    public function setIdRegion(int $idRegion):void{
        $this -> idRegion = $idRegion;
    }

    public function getIdRegion ():int{
        return $this -> idRegion;
    }

    public function setRegion (string $region){
        $this -> region = $region;
    }

    public function getRegion ():string{
        return $this -> region;
    }
}