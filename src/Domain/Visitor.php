<?php

namespace GSB\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class Visitor implements UserInterface
{
    /**
     * Visitor id.
     *
     * @var integer
     */
    private $id;

    /**
     * Last name.
     *
     * @var string
     */
    private $lastName;

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
     * Hiring date.
     *
     * @var DateTime
     */
    private $hiringDate;

    /**
     * User name (used for authentication).
     *
     * @var string
     */
    private $username;

    /**
     * Password.
     *
     * @var string
     */
    private $password;

    /**
     * Salt that was originally used to encode the password.
     *
     * @var string
     */
    private $salt;

    /**
     * Role.
     *
     * @var string
     */
    private $role;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Set last name.
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    
    /**
     * Returns last name.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * Set first name.
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    
    /**
     * Returns first name.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set address.
     *
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }
    
    /**
     * Returns address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zip code.
     *
     * @param string $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
    }
    
    /**
     * Returns zip code.
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set city.
     *
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }
    
    /**
     * Returns city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set hiring date.
     *
     * @param DateTime $hiringDate
     */
    public function setHiringDate($hiringDate)
    {
        $this->hiringDate = $hiringDate;
    }
    
    /**
     * Returns hiring date.
     *
     * @return DateTime
     */
    public function getHiringDate()
    {
        return $this->hiringDate;
    }

    /**
     * @inheritDoc
     */
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @inheritDoc
     */
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array($this->getRole());
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        // Nothing to do here
    }
}