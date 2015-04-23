<?php

namespace GSB\DAO;

use GSB\Domain\Specialite;
use GSB\Domain\Practitioner;
use GSB\Domain\LineSpecialite;

class SpecialiteDAO extends DAO {

    /**
     * Returns the list of all practitioner types, sorted by name.
     *
     * @return array The list of all practitioner types.
     */
    public function findAll() {
        $sql = "select * from speciality";
        $result = $this->getDb()->fetchAll($sql);

        // Converts query result to an array of domain objects
        $specialite = array();
        foreach ($result as $row) {
            $specialityId = $row['speciality_id'];
            $specialite[$specialityId] = $this->buildDomainObject($row);
        }
        return $specialite;
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
     * Returns the list of all practitioner types, sorted by name.
     *
     * @return array The list of all practitioner types.
     */
    public function findAllByPractitioner(Practitioner $practitioner) {
        $sql = "select * "
                . " from speciality sp join owning ow"
                . " on sp.speciality_id = ow.speciality_id"
                . " where practitioner_id=?";
        $result = $this->getDb()->fetchAll($sql, array($practitioner->getId()));

        // Converts query result to an array of domain objects
        $lineSpecialites = array();
        foreach ($result as $row) {
            $lineSpecialites[] = $this->buildLineSpecialiteObject($row, $practitioner);
        }
        return $lineSpecialites;
    }

    /**
     * Returns the list of all practitioner types, sorted by name.
     *
     * @return array The list of all practitioner types.
     */
    public function existLineSpecialite(LineSpecialite $lineSpecialite) {
        $practitionerId = $lineSpecialite->getPractitioner()->getId();
        $specialiteId = $lineSpecialite->getSpecialite()->getId();
        $sql = "select * "
                . " from owning "
                . " where practitioner_id=? and speciality_id=?";
        $result = $this->getDb()->fetchAll($sql, array($practitionerId, $specialiteId));

        // Converts query result to an array of domain objects
        if ($result)
            return TRUE;
        else
            return FALSE;
    }

    public function saveLineSpecialite(LineSpecialite $lineSpecialite) {
        $practitionerId = $lineSpecialite->getPractitioner()->getId();
        $specialiteId = $lineSpecialite->getSpecialite()->getId();
        $exist = $this->existLineSpecialite($lineSpecialite);
        $lineSpecialiteData = array(
            'graduate' => $lineSpecialite->getGraduate(),
            'prescription_coefficient' => $lineSpecialite->getPrescriptionCoefficient()
        );
        if ($exist)
            $this->getDb()->update('owning', $lineSpecialiteData, array('practitioner_id' => $practitionerId, 'speciality_id' => $specialiteId));
        else {
            $lineSpecialiteData['practitioner_id'] = $practitionerId;
            $lineSpecialiteData['speciality_id'] = $specialiteId;
            $this->getDb()->insert('owning', $lineSpecialiteData);
        }
        return $exist;
    }

    /**
     * Removes an LineSpecialite from the database.
     *
     * @param \AgnamStore\Domain\LineSpecialite $lineSpecialite The ItemCart to remove
     */
    public function deleteLineSpecialite($practitionerId,$specialiteId) {
        $this->getDb()->delete('owning', array('practitioner_id' => $practitionerId, 'speciality_id' => $specialiteId));
    }

    /**
     * Creates a Specialite instance from a DB query result row.
     *
     * @param array $row The DB query result row.
     *
     * @return \GSB\Domain\Specialite
     */
    protected function buildLineSpecialiteObject($row, Practitioner $practitioner) {
        $lineSpecialite = new LineSpecialite();
        $lineSpecialite->setPractitioner($practitioner);
        $lineSpecialite->setGraduate($row['graduate']);
        $lineSpecialite->setPrescriptionCoefficient($row['prescription_coefficient']);
        $lineSpecialite->setSpecialite($this->buildDomainObject($row));
        return $lineSpecialite;
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
        return $specialite;
    }

}
