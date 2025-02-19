<?php

include_once('AbstractEntity.php');

class Departement extends AbstractEntity{

    private $idDepartement;
    private ? string $departement = null;
    private $code;
    private $idRegion;

    public function setIdDepartement(int $idDepartement):void{
        $this -> idDepartement = $idDepartement;
    }

    public function getIdDepartement ():int{
        return $this -> idDepartement;
    }

    public function setDepartement (?string $departement){
        $this -> departement = $departement;
    }

    public function getDepartement ():?string{
        return $this -> departement;
    }

    public function setCode (string $code){
        $this -> code = $code;
    }

    public function getCode ():string{
        return $this -> code;
    }

    public function setIdRegion (int $idRegion){
        $this -> idRegion = $idRegion;
    }

    public function getIdRegion ():int{
        return $this -> idRegion;
    }
}