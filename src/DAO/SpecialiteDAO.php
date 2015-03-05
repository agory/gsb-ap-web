<?php

namespace GSB\DAO;

use GSB\Domain\Specialite;

class SpecialiteDAO extends DAO
{
    /**
     * Returns the list of all practitioner types, sorted by name.
     *
     * @return array The list of all practitioner types.
     */
    public function findAll() {
        $sql = "select * from speciality order";
        $result = $this->getDb()->fetchAll($sql);
        
        // Converts query result to an array of domain objects
        $practitionerTypes = array();
        foreach ($result as $row) {
            $practitionerTypeId = $row['practitioner_type_id'];
            $practitionerTypes[$practitionerTypeId] = $this->buildDomainObject($row);
        }
        return $practitionerTypes;
    }

    /**
     * Returns the Specialite matching the given id.
     *
     * @param integer $id
     *
     * @return \GSB\Domain\Specialite|throws an exception if no Specialite is found.
     */
    public function find($id) {
        $sql = "select * from speciality where 	speciality_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No Specialite found for id " . $id);
    }

    /**
     * Creates a Specialite instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \GSB\Domain\Specialite
     */
    protected function buildDomainObject($row) {
        $specialite = new Specialite();
        $specialite->setId($row['speciality_id']);
        $specialite->setName($row['speciality_name']);
        return $practitionerType;
    }
}