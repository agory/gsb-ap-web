<?php

namespace GSB\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use GSB\Domain\Visitor;

class VisitorDAO extends DAO implements UserProviderInterface
{
    /**
     * Returns a visitor matching the supplied id.
     *
     * @param integer $id
     *
     * @return \GSB\Domain\Visitor|throws an exception if no matching user is found
     */
    public function find($id) {
        $sql = "select * from visitor where visitor_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No visitor matching id " . $id);
    }

    /**
     * Saves a visitor into the database.
     *
     * @param \GSB\Domain\Visitor $visitor The visitor to save
     */
    public function save($visitor) {
        $hiringDateString = $visitor->getHiringDate()->format('Y-m-d');
        $visitorData = array(
            'visitor_last_name' => $visitor->getLastName(),
            'visitor_first_name' => $visitor->getFirstName(),
            'visitor_address' => $visitor->getAddress(),
            'visitor_zip_code' => $visitor->getZipCode(),
            'visitor_city' => $visitor->getCity(),
            'hiring_date' => $hiringDateString,
            'user_name' => $visitor->getUsername(),
            'password' => $visitor->getPassword(),
            );

        if ($visitor->getId()) {
            // The visitor has already been saved : update it
            $this->getDb()->update('visitor', $visitorData, array('visitor_id' => $visitor->getId()));
        } else {
            // The visitor has never been saved : insert it
            $this->getDb()->insert('visitor', $visitorData);
            // Get the id of the newly created visitor and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $visitor->setId($id);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $sql = "select * from visitor where user_name=?";
        $row = $this->getDb()->fetchAssoc($sql, array($username));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new UsernameNotFoundException(sprintf('Visitor "%s" not found.', $username));
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'GSB\Domain\Visitor' === $class;
    }

    /**
     * Creates a Visitor object based on a DB row.
     *
     * @param array $row The DB row containing Visitor data.
     * @return \GSB\Domain\Visitor
     */
    protected function buildDomainObject($row) {
        $visitor = new Visitor();
        $visitor->setId($row['visitor_id']);
        $visitor->setLastName($row['visitor_last_name']);
        $visitor->setFirstName($row['visitor_first_name']);
        $visitor->setAddress($row['visitor_address']);
        $visitor->setZipCode($row['visitor_zip_code']);
        $visitor->setCity($row['visitor_city']);
        // Transform the DB date into a DateTime object
        $hiringDate = \DateTime::createFromFormat('Y-m-d', $row['hiring_date']);
        $visitor->setHiringDate($hiringDate);
        $visitor->setUsername($row['user_name']);
        $visitor->setPassword($row['password']);
        $visitor->setSalt($row['salt']);
        $visitor->setRole($row['role']);
        return $visitor;
    }
}