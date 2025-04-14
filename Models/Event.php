<?php

include_once('AbstractEntity.php');

class Event extends AbstractEntity{

    private $idEvent;
    private $idUser;
    private $title;
    private $description;
    private $location;
    private $start;
    private $end;
    private $all_day;
    private $is_recurring;
    private $recurrence_rule;
    private $background_color;
    private $border_color;
    private $text_color;
    private $created_at;
    private $updated_at;


    public function setIdEvent(int $idEvent):void{
        $this -> idEvent = $idEvent;
    }
    public function getIdEvent ():int{
        return $this -> idEvent;
    }
    public function setIdUser(int $idUser):void{
        $this -> idUser = $idUser;
    }
    public function getIdUser ():int{
        return $this -> idUser;
    }
    public function setTitle(string $title):void{
        $this -> title = $title;
    }
    public function getTitle ():string{
        return $this -> title;
    }
    public function setDescription(string $description):void{
        $this -> description = $description;
    }
    public function getDescription ():string{
        return $this -> description;
    }
    public function setLocation(string $location):void{
        $this -> location = $location;
    }
    public function getLocation ():string{
        return $this -> location;
    }
    public function setStart(string $start):void{
        $this -> start = $start;
    }
    public function getStart ():string{
        return $this -> start;
    }
    public function setEnd(string $end):void{
        $this -> end = $end;
    }
    public function getEnd ():string{
        return $this -> end;
    }
    public function setAllDay(bool $all_day):void{
        $this -> all_day = $all_day;
    }
    public function getAllDay ():bool{
        return $this -> all_day;
    }
    public function setIsRecurring(bool $is_recurring):void{
        $this -> is_recurring = $is_recurring;
    }
    public function getIsRecurring ():bool{
        return $this -> is_recurring;
    }
    public function setRecurrenceRule(string $recurrence_rule):void{
        $this -> recurrence_rule = $recurrence_rule;
    }
    public function getRecurrenceRule ():string{
        return $this -> recurrence_rule;
    }
    public function setBackgroundColor(string $background_color):void{
        $this -> background_color = $background_color;
    }
    public function getBackgroundColor ():string{
        return $this -> background_color;
    }
    public function setBorderColor(string $border_color):void{
        $this -> border_color = $border_color;
    }
    public function getBorderColor ():string{
        return $this -> border_color;
    }
    public function setTextColor(string $text_color):void{
        $this -> text_color = $text_color;
    }
    public function getTextColor ():string{
        return $this -> text_color;
    }
    public function setCreatedAt(string $created_at):void{
        $this -> created_at = $created_at;
    }
    public function getCreatedAt ():string{
        return $this -> created_at;
    }
    public function setUpdatedAt(string $updated_at):void{
        $this -> updated_at = $updated_at;
    }
    public function getUpdatedAt ():string{
        return $this -> updated_at;
    }
    public function getCreatedAtFormatFr(): string {
        if ($this->created_at) {
            return date('d/m/Y H:i:s', strtotime($this->created_at));
        }
        return '';
    }
    public function getUpdatedAtFormatFr(): string {
        if ($this->updated_at) {
            return date('d/m/Y H:i:s', strtotime($this->updated_at));
        }
        return '';
    }
}
