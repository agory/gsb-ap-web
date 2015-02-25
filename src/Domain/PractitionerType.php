<?php

namespace GSB\Domain;

class PractitionerType 
{
    /**
     * PractitionerType id.
     *
     * @var integer
     */
    private $id;

    /**
     * Name.
     *
     * @var string
     */
    private $name;

    /**
     * Place.
     *
     * @var string
     */
    private $place;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getPlace() {
        return $this->place;
    }

    public function setPlace($place) {
        $this->place = $place;
    }
}