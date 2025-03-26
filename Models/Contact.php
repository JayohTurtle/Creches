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
    public $localisation;
    public array $localisations = [];
    private array $interetsCreche = [];

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

    public function setLocalisation(?Localisation $localisation) {
        $this->localisation = $localisation;
    }

    public function getLocalisation(): ?Localisation {
        return $this->localisation;
    }

    public function ajouterLocalisation(Localisation $localisation) {
        $this->localisations[] = $localisation;
    }

    public function setLocalisations(array $localisations) {
        $this->localisations[] = $localisations;
    }

    public function getLocalisations(): array {
        return $this->localisations;
    }
    
    public function ajouterInteretCreche(InteretCreche $interetCreche) {
        $this->interetsCreche[] = $interetCreche;
    }

    public function getInteretsCreche(): array {
        return $this->interetsCreche;
    }

    public function setInteretsCreche(array $interetsCreche) {
        $this->interetsCreche = $interetsCreche;
    }
}