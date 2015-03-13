<?php

namespace GSB\Domain;

class LineSpecialite {
    /**
     * LineSpecialite $practitioner.
     *
     * @var \GSB\Domaine\Practitioner
     */
    private $practitioner;
    
    /**
     * LineSpecialite $specialite.
     *
     * @var \GSB\Domaine\Specialite
     */
    private $specialite;
    
    /**
     * LineSpecialite $graduate.
     *
     * @var string
     */
    private $graduate;
    
    /**
     * LineSpecialite $prescriptionCoefficient.
     *
     * @var float
     */
    private $prescriptionCoefficient;
    
    public function getPractitioner() {
        return $this->practitioner;
    }

    public function getSpecialite() {
        return $this->specialite;
    }

    public function getGraduate() {
        return $this->graduate;
    }

    public function getPrescriptionCoefficient() {
        return $this->prescriptionCoefficient;
    }

    public function setPractitioner($practitioner) {
        $this->practitioner = $practitioner;
        return $this;
    }

    public function setSpecialite($specialite) {
        $this->specialite = $specialite;
        return $this;
    }

    public function setGraduate($graduate) {
        $this->graduate = $graduate;
        return $this;
    }

    public function setPrescriptionCoefficient($prescriptionCoefficient) {
        $this->prescriptionCoefficient = $prescriptionCoefficient;
        return $this;
    }


    
}
