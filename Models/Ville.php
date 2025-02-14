<?php

include_once('AbstractEntity.php');

class Ville extends AbstractEntity{

    private $idVille;
    private $ville;
    private $codePostal;
    private $idDepartement;

    public function setIdVille(int $idVille):void{
        $this -> idVille = $idVille;
    }

    public function getIdVille ():int{
        return $this -> idVille;
    }

    public function setVille (string $ville){
        $this -> ville = $ville;
    }

    public function getVille ():string{
        return $this -> ville;
    }

    public function setCodePostal (string $codePostal){
        $this -> codePostal = $codePostal;
    }

    public function getCodePostal ():string{
        return $this -> codePostal;
    }

    public function setIdDepartement (int $idDepartement){
        $this -> idDepartement = $idDepartement;
    }

    public function getIdDepartement ():int{
        return $this -> idDepartement;
    }
    
}