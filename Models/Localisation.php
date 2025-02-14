<?php

include_once('AbstractEntity.php');

class Localisation extends AbstractEntity {

    private $idLocalisation;
    private $idContact;
    private $idVille;
    private $adresse;
    private $idDepartement;
    private $identifiant;
    private $taille;

    public function setIdLocalisation(int $idLocalisation): void {
        $this->idLocalisation = $idLocalisation;
    }

    public function getIdLocalisation(): int {
        return $this->idLocalisation;
    }

    public function setIdContact(int $idContact) {
        $this->idContact = $idContact;
    }

    public function getIdContact(): int {
        return $this->idContact;
    }

    public function setIdVille(int $idVille) {
        $this->idVille = $idVille;
    }

    public function getIdVille(): int {
        return $this->idVille;
    }

    public function setAdresse(string $adresse) {
        $this->adresse = $adresse;
    }

    public function getAdresse(): string {
        return $this->adresse;
    }

    public function setIdDepartement(int $idDepartement) {
        $this->idDepartement = $idDepartement;
    }

    public function getIdDepartement(): int {
        return $this->idDepartement;
    }

    public function setidentifiant(string $identifiant) {
        $this->identifiant = $identifiant;
    }

    public function getidentifiant(): string {
        return $this->identifiant;
    }

    public function setTaille(string $taille) {
        $this->taille = $taille;
    }

    public function getTaille(): string {
        return $this->taille;
    }
}
