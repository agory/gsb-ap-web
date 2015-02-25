<?php

namespace GSB\DAO;

use GSB\Domain\PractitionerType;

class PractitionerTypeDAO extends DAO
{
    /**
     * Returns the list of all practitioner types, sorted by name.
     *
     * @return array The list of all practitioner types.
     */
    public function findAll() {
        $sql = "select * from practitioner_type order by practitioner_type_name";
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
     * Returns the PractitionerType matching the given id.
     *
     * @param integer $id
     *
     * @return \GSB\Domain\PractitionerType|throws an exception if no PractitionerType is found.
     */
    public function find($id) {
        $sql = "select * from practitioner_type where practitioner_type_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No PractitionerType found for id " . $id);
    }

    /**
     * Creates a PractitionerType instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \GSB\Domain\PractitionerType
     */
    protected function buildDomainObject($row) {
        $practitionerType = new PractitionerType();
        $practitionerType->setId($row['practitioner_type_id']);
        $practitionerType->setName($row['practitioner_type_name']);
        $practitionerType->setPlace($row['practitioner_type_place']);
        return $practitionerType;
    }
}