<?php

namespace GSB\Domain;

class Practitioner 
{
    /**
     * Practitioner id.
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
     * First name.
     *
     * @var string
     */
    private $firstName;

    /**
     * Address.
     *
     * @var string
     */
    private $address;

    /**
     * Zip Code.
     *
     * @var string
     */
    private $zipCode;

    /**
     * City.
     *
     * @var string
     */
    private $city;

    /**
     * Notoriety coefficient.
     *
     * @var float
     */
    private $notorietyCoefficient;

    /**
     * Type.
     *
     * @var \GSB\Domaine\PractitionerType
     */
    private $type;

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

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getZipCode() {
        return $this->zipCode;
    }

    public function setZipCode($zipCode) {
        $this->zipCode = $zipCode;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getNotorietyCoefficient() {
        return $this->notorietyCoefficient;
    }

    public function setnotorietyCoefficient($notorietyCoefficient) {
        $this->notorietyCoefficient = $notorietyCoefficient;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function __toString() {
        return $this->getFirstName() . ' ' . $this->getName() ;
    }
}