<?php

include_once('AbstractEntity.php');

class Contact extends AbstractEntity{

    private $idContact;
    private ?string $nom = null;
    private ?string $contact = null;
    private ?string $siren = null;
    private ?string $email = null;
    private ?string $telephone = null;
    private ?string $siteInternet = null;
    private $sens;
    private string $niveau;
    private $nbCreches;
    private ?Departement $departement = null; // Stocke le département du contact
    private ?Ville $ville = null; // Stocke le département du contact
    
    public function setVille(?Ville $ville) {
        $this->ville = $ville;
    }

    public function getVille(): ?Ville {
        return $this->ville;
    }  
    
    public function setDepartement(?Departement $departement) {
        $this->departement = $departement;
    }

    public function getDepartement(): ?Departement {
        return $this->departement;
    }  

    public function setIdContact(int $idContact):void{
        $this -> idContact = $idContact;
    }

    public function getIdContact ():int{
        return $this -> idContact;
    }

    public function setNom (?string $nom){
        $this -> nom = $nom;
    }

    public function getNom ():?string{
        return $this -> nom;
    }

    public function setContact (?string $contact){
        $this -> contact = $contact;
    }

    public function getContact ():?string{
        return $this -> contact;
    }

    public function setSiren (?string $siren){
        $this -> siren = $siren;
    }

    public function getSiren ():?string{
        return $this -> siren;
    }

    public function setEmail (?string $email){
        $this -> email = $email;
    }

    public function getEmail ():?string{
        return $this -> email;
    }

    public function setTelephone (?string $telephone){
        $this -> telephone = $telephone;
    }

    public function getTelephone ():?string{
        return $this -> telephone;
    }

    public function setSiteInternet (?string $siteInternet){
        $this -> siteInternet = $siteInternet;
    }

    public function getSiteInternet ():?string{
        return $this -> siteInternet;
    }

    public function setSens (string $sens){
        $this -> sens = $sens;
    }

    public function getSens ():string{
        return $this -> sens;
    }

    public function setNiveau (string $niveau){
        $this -> niveau = $niveau;
    }

    public function getNiveau ():string{
        return $this -> niveau;
    }

    public function setNbCreches ($nbCreches){
        $this -> nbCreches = $nbCreches;
    }

    public function getNbCreches ():int{
        return $this -> nbCreches;
    }    
}
