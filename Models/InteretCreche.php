<?php

include_once('AbstractEntity.php');

class InteretCreche extends AbstractEntity{

    private $idInteretCreche;
    private $idContact;
    private $niveau;
    private $idLocalisation;
    private $identifiant;
    private $dateColonne;
    private $localisation;
    private $contact;
    private $ville;
    private $departement;   
    private $region;
    private array $niveaux = [];
    private array $contacts = [];
    

    public function setNiveaux (array $niveaux){
        $this -> niveaux = $niveaux;
    }

    public function getNiveaux ():array {
        return $this -> niveaux;
    }

    public function setContacts (array $contacts){
        var_dump($contacts); //
        $this -> contacts = $contacts;
    }
    
    public function getContacts ():array {
        return $this -> contacts;
    }
    
    
    public function setRegion ($region){
        $this -> region = $region;
    }

    public function getRegion (){
        return $this -> region;
    }

    public function setDepartement ($departement){
        $this -> departement = $departement;
    }

    public function getDepartement (){
        return $this -> departement;
    }

    public function setVille ($ville){
        $this -> ville = $ville;
    }

    public function getVille (){
        return $this -> ville;
    }

    public function setContact ($contact){
        $this -> contact = $contact;
    }

    public function getContact (){
        return $this -> contact;
    }

    public function setLocalisation ($localisation){
        $this -> localisation = $localisation;
    }

    public function getLocalisation (){
        return $this -> localisation;
    }

    public function setIdInteretCreche(int $idInteretCreche):void{
        $this -> idInteretCreche = $idInteretCreche;
    }

    public function getIdInteretCreche ():int{
        return $this -> idInteretCreche;
    }

    public function setIdContact (int $idContact){
        $this -> idContact = $idContact;
    }

    public function getIdContact ():int{
        return $this -> idContact;
    }

    public function setNiveau (string $niveau){
        $this -> niveau = $niveau;
    }

    public function getNiveau ():string{
        return $this -> niveau;
    }

    public function setDateColonne (string $dateColonne){
        $this -> dateColonne = $dateColonne;
    }

    public function getDateColonne ():string{
        return $this -> dateColonne;
    }

    public function getDateColonneFormatFr(): string {
        if ($this->dateColonne) {
            $date = DateTime::createFromFormat('Y-m-d', $this->dateColonne);
            return $date ? $date->format('d-m-Y') : "";
        }
        return "";
    }

    public function setIdLocalisation(int $idLocalisation){
        $this -> idLocalisation = $idLocalisation;
    }

    public function getIdLocalisation ():int{
        return $this -> idLocalisation;
    }

    public function setIdentifiant (string $identifiant){
        $this -> identifiant = $identifiant;
    }

    public function getIdentifiant ():string{
        return $this -> identifiant;
    }

    // ✅ Méthode pour ajouter des niveaux et contacts sans écraser les précédents
    public function ajouterInteret(string $niveau, array $contact) {
        $this->niveaux[] = $niveau;
        $this->contacts[] = $contact;
    }

    //Méthodes pour ajouter des niveaux et contacts sans écraser les précédents
    public function ajouterNiveau($niveau) {
        $this->niveaux[] = $niveau;
    }

    public function ajouterContact($contact) {
        $this->contact[] = $contact;
    }
}