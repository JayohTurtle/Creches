<?php

include_once('AbstractEntity.php');

class Comment extends AbstractEntity {
    private $idComment;
    private $idContact;
    private $commentaire;
    private $dateComment;
    private $operateur;

    public function setIdComment(int $idComment): void {
        $this->idComment = $idComment;
    }

    public function getIdComment(): int {
        return $this->idComment;
    }

    public function setIdContact(string $idContact): void {
        $this->idContact = $idContact;
    }

    public function getIdContact(): string {
        return $this->idContact;
    }

    public function setCommentaire(string $commentaire): void {
        $this->commentaire = $commentaire;
    }

    public function getCommentaire(): string {
        return $this->commentaire;
    }

    public function setDateComment(string $dateComment): void {
        $this->dateComment = $dateComment;
    }

    public function getDateComment(): string {
        return $this->dateComment;
    }

    public function getDateCommentFormatFr(): string {
        if ($this->dateComment) {
            $date = DateTime::createFromFormat('Y-m-d', $this->dateComment);
            return $date ? $date->format('d-m-Y') : "";
        }
        return "";
    }

    public function setOperateur(string $operateur): void {
        $this->operateur = $operateur;
    }

    public function getOperateur(): string {
        return $this->operateur;
    }
}