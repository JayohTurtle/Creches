<?php

include_once('AbstractEntityManager.php');

class EventManager extends AbstractEntityManager {

    public function insertEvent(Event $event) {
        $sql = 'INSERT INTO events (idUser, title, description, location, start, end, all_day, is_recurring, recurrence_rule, background_color, border_color, text_color) 
                VALUES (:idUser, :title, :description, :location, :start, :end, :all_day, :is_recurring, :recurrence_rule, :background_color, :border_color, :text_color)';
        
        $this->db->query($sql, [
            'idUser' => $event->getIdUser(),
            'title' => $event->getTitle(),
            'description' => $event->getDescription(),
            'location' => $event->getLocation(),
            'start' => $event->getStart(),
            'end' => $event->getEnd(),
            'all_day' => $event->getAllDay(),
            'is_recurring' => $event->getIsRecurring(),
            'recurrence_rule' => $event->getRecurrenceRule(),
            'background_color' => $event->getBackgroundColor(),
            'border_color' => $event->getBorderColor(),
            'text_color' => $event->getTextColor()
        ]);
    }
    public function getEventsByUserId($idUser) {
        $sql = 'SELECT * FROM events WHERE idUser = :idUser';
        $query = $this->db->query($sql, ['idUser' => $idUser]);
        $events = [];

        while ($row = $query->fetch()) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            $events[] = $event;
        }

        return $events;
    }
    public function getEventById($idEvent) {
        $sql = 'SELECT * FROM events WHERE idEvent = :idEvent';
        $query = $this->db->query($sql, ['idEvent' => $idEvent]);
        $row = $query->fetch();

        if ($row) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            return $event;
        }

        return null;
    }
    public function updateEvent(Event $event) {
        $sql = 'UPDATE events SET title = :title, description = :description, location = :location, start = :start, end = :end, all_day = :all_day, is_recurring = :is_recurring, recurrence_rule = :recurrence_rule, background_color = :background_color, border_color = :border_color, text_color = :text_color WHERE idEvent = :idEvent';
        
        $this->db->query($sql, [
            'idEvent' => $event->getIdEvent(),
            'title' => $event->getTitle(),
            'description' => $event->getDescription(),
            'location' => $event->getLocation(),
            'start' => $event->getStart(),
            'end' => $event->getEnd(),
            'all_day' => $event->getAllDay(),
            'is_recurring' => $event->getIsRecurring(),
            'recurrence_rule' => $event->getRecurrenceRule(),
            'background_color' => $event->getBackgroundColor(),
            'border_color' => $event->getBorderColor(),
            'text_color' => $event->getTextColor()
        ]);
    }
    public function deleteEvent($idEvent) {
        $sql = 'DELETE FROM events WHERE idEvent = :idEvent';
        $this->db->query($sql, ['idEvent' => $idEvent]);
    }
    public function getAllEvents() {
        $sql = 'SELECT * FROM events';
        $query = $this->db->query($sql);
        $events = [];

        while ($row = $query->fetch()) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            $events[] = $event;
        }

        return $events;
    }
    public function getEventsByDate($date) {
        $sql = 'SELECT * FROM events WHERE DATE(start) = :date OR DATE(end) = :date';
        $query = $this->db->query($sql, ['date' => $date]);
        $events = [];

        while ($row = $query->fetch()) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            $events[] = $event;
        }

        return $events;
    }
    public function getEventsByMonth($month) {
        $sql = 'SELECT * FROM events WHERE MONTH(start) = :month OR MONTH(end) = :month';
        $query = $this->db->query($sql, ['month' => $month]);
        $events = [];

        while ($row = $query->fetch()) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            $events[] = $event;
        }

        return $events;
    }
    public function getEventsByYear($year) {
        $sql = 'SELECT * FROM events WHERE YEAR(start) = :year OR YEAR(end) = :year';
        $query = $this->db->query($sql, ['year' => $year]);
        $events = [];

        while ($row = $query->fetch()) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            $events[] = $event;
        }

        return $events;
    }
    public function getEventsByUserIdAndDate($idUser, $date) {
        $sql = 'SELECT * FROM events WHERE idUser = :idUser AND (DATE(start) = :date OR DATE(end) = :date)';
        $query = $this->db->query($sql, ['idUser' => $idUser, 'date' => $date]);
        $events = [];

        while ($row = $query->fetch()) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            $events[] = $event;
        }

        return $events;
    }
    public function getEventsByUserIdAndMonth($idUser, $month) {
        $sql = 'SELECT * FROM events WHERE idUser = :idUser AND (MONTH(start) = :month OR MONTH(end) = :month)';
        $query = $this->db->query($sql, ['idUser' => $idUser, 'month' => $month]);
        $events = [];

        while ($row = $query->fetch()) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            $events[] = $event;
        }

        return $events;
    }
    public function getEventsByUserIdAndYear($idUser, $year) {
        $sql = 'SELECT * FROM events WHERE idUser = :idUser AND (YEAR(start) = :year OR YEAR(end) = :year)';
        $query = $this->db->query($sql, ['idUser' => $idUser, 'year' => $year]);
        $events = [];

        while ($row = $query->fetch()) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            $events[] = $event;
        }

        return $events;
    }
    public function getEventsByUserIdAndDateRange($idUser, $startDate, $endDate) {
        $sql = 'SELECT * FROM events WHERE idUser = :idUser AND (start BETWEEN :startDate AND :endDate OR end BETWEEN :startDate AND :endDate)';
        $query = $this->db->query($sql, ['idUser' => $idUser, 'startDate' => $startDate, 'endDate' => $endDate]);
        $events = [];

        while ($row = $query->fetch()) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            $events[] = $event;
        }

        return $events;
    }
    public function getEventsByUserIdAndMonthRange($idUser, $startMonth, $endMonth) {
        $sql = 'SELECT * FROM events WHERE idUser = :idUser AND (MONTH(start) BETWEEN :startMonth AND :endMonth OR MONTH(end) BETWEEN :startMonth AND :endMonth)';
        $query = $this->db->query($sql, ['idUser' => $idUser, 'startMonth' => $startMonth, 'endMonth' => $endMonth]);
        $events = [];

        while ($row = $query->fetch()) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            $events[] = $event;
        }

        return $events;
    }
    public function getEventsByUserIdAndYearRange($idUser, $startYear, $endYear) {
        $sql = 'SELECT * FROM events WHERE idUser = :idUser AND (YEAR(start) BETWEEN :startYear AND :endYear OR YEAR(end) BETWEEN :startYear AND :endYear)';
        $query = $this->db->query($sql, ['idUser' => $idUser, 'startYear' => $startYear, 'endYear' => $endYear]);
        $events = [];

        while ($row = $query->fetch()) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            $events[] = $event;
        }

        return $events;
    }
    public function getEventsByUserIdAndDateRangeAndLocation($idUser, $startDate, $endDate, $location) {
        $sql = 'SELECT * FROM events WHERE idUser = :idUser AND (start BETWEEN :startDate AND :endDate OR end BETWEEN :startDate AND :endDate) AND location = :location';
        $query = $this->db->query($sql, ['idUser' => $idUser, 'startDate' => $startDate, 'endDate' => $endDate, 'location' => $location]);
        $events = [];

        while ($row = $query->fetch()) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            $events[] = $event;
        }

        return $events;
    }
    public function getEventsByUserIdAndMonthRangeAndLocation($idUser, $startMonth, $endMonth, $location) {
        $sql = 'SELECT * FROM events WHERE idUser = :idUser AND (MONTH(start) BETWEEN :startMonth AND :endMonth OR MONTH(end) BETWEEN :startMonth AND :endMonth) AND location = :location';
        $query = $this->db->query($sql, ['idUser' => $idUser, 'startMonth' => $startMonth, 'endMonth' => $endMonth, 'location' => $location]);
        $events = [];

        while ($row = $query->fetch()) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            $events[] = $event;
        }

        return $events;
    }
    public function getEventsByUserIdAndYearRangeAndLocation($idUser, $startYear, $endYear, $location) {
        $sql = 'SELECT * FROM events WHERE idUser = :idUser AND (YEAR(start) BETWEEN :startYear AND :endYear OR YEAR(end) BETWEEN :startYear AND :endYear) AND location = :location';
        $query = $this->db->query($sql, ['idUser' => $idUser, 'startYear' => $startYear, 'endYear' => $endYear, 'location' => $location]);
        $events = [];

        while ($row = $query->fetch()) {
            $event = new Event();
            $event->setIdEvent($row['idEvent']);
            $event->setIdUser($row['idUser']);
            $event->setTitle($row['title']);
            $event->setDescription($row['description']);
            $event->setLocation($row['location']);
            $event->setStart($row['start']);
            $event->setEnd($row['end']);
            $event->setAllDay($row['all_day']);
            $event->setIsRecurring($row['is_recurring']);
            $event->setRecurrenceRule($row['recurrence_rule']);
            $event->setBackgroundColor($row['background_color']);
            $event->setBorderColor($row['border_color']);
            $event->setTextColor($row['text_color']);

            $events[] = $event;
        }

        return $events;
    }
}