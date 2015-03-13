<?php

namespace GSB\Domain;

class Activity 
{
    /**
     * Activity id.
     *
     * @var integer
     */
    private $id;
    
    /**
     * Activity date.
     *
     * @var DateTime
     */
    private $date;
    
    /**
     * Activity place.
     *
     * @var string
     */
    private $place;
    
    /**
     * Activity theme.
     *
     * @var string
     */
    private $theme;
    
    /**
     * Activity purpose.
     *
     * @var string
     */
    private $purpose;
    
    
    public function getId() {
        return $this->id;
    }

    public function getDate() {
        return new \DateTime($this->date);
    }

    public function getPlace() {
        return $this->place;
    }

    public function getTheme() {
        return $this->theme;
    }

    public function getPurpose() {
        return $this->purpose;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setPlace($place) {
        $this->place = $place;
    }

    public function setTheme($theme) {
        $this->theme = $theme;
    }

    public function setPurpose($purpose) {
        $this->purpose = $purpose;
    }
}
