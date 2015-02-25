<?php

namespace GSB\Domain;

class VisitReport 
{
    /**
     * Report id.
     *
     * @var integer
     */
    private $id;

    /**
     * Practitioner.
     *
     * @var \GSB\Domain\Practitioner
     */
    private $practitioner;

    /**
     * Visitor.
     *
     * @var \GSB\Domain\Visitor
     */
    private $visitor;

    /**
     * Report date.
     *
     * @var DateTime
     */
    private $date;

    /**
     * Purpose.
     *
     * @var string
     */
    private $purpose;

    /**
     * Assessment.
     *
     * @var string
     */
    private $assessment;

    /**
     * Returns report id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set report id.
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Returns practitioner.
     *
     * @return \GSB\Domain\Practitioner
     */
    public function getPractitioner()
    {
        return $this->practitioner;
    }
    
    /**
     * Set practitioner.
     *
     * @param \GSB\Domain\Practitioner $practitioner
     */
    public function setPractitioner($practitioner)
    {
        $this->practitioner = $practitioner;
    }

    /**
     * Returns visitor.
     *
     * @return \GSB\Domain\Visitor
     */
    public function getVisitor()
    {
        return $this->visitor;
    }
    
    /**
     * Set visitor.
     *
     * @param \GSB\Domain\Visitor $visitor
     */
    public function setVisitor($visitor)
    {
        $this->visitor = $visitor;
    }

    /**
     * Returns date.
     *
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * Set date.
     *
     * @param DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Returns purpose.
     *
     * @return string
     */
    public function getPurpose()
    {
        return $this->purpose;
    }
    
    /**
     * Set purpose.
     *
     * @param string $purpose
     */
    public function setPurpose($purpose)
    {
        $this->purpose = $purpose;
    }

    /**
     * Returns assessment.
     *
     * @return string
     */
    public function getAssessment()
    {
        return $this->assessment;
    }
    
    /**
     * Set assessment.
     *
     * @param string $assessment
     */
    public function setAssessment($assessment)
    {
        $this->assessment = $assessment;
    }
}