<?php

namespace GSB\DAO;

use GSB\Domain\VisitReport;

class VisitReportDAO extends DAO 
{
    /**
     * @var \GSB\DAO\PractitionerDAO
     */
    protected $practitionerDAO;

    /**
     * @var \GSB\DAO\VisitorDAO
     */
    protected $visitorDAO;

    public function setpractitionerDAO($practitionerDAO) {
        $this->practitionerDAO = $practitionerDAO;
    }

    public function setvisitorDAO($visitorDAO) {
        $this->visitorDAO = $visitorDAO;
    }

    /**
     * Returns a list of all visit reports for a visitor, sorted by date (most recent first).
     *
     * @param $visitorId The visitor id.
     *
     * @return array A list of all visit reports for the visitor.
     */
    public function findAllByVisitor($visitorId) {
        $sql = "select * from visit_report where visitor_id=? order by reporting_date";
        $result = $this->getDb()->fetchAll($sql, array($visitorId));
        
        // Convert query result to an array of domain objects
        $visitReports = array();
        foreach ($result as $row) {
            $visitReportId = $row['report_id'];
            $visitReports[$visitReportId] = $this->buildDomainObject($row);
        }
        return $visitReports;
    }

    /**
     * Saves a visit report into the database.
     *
     * @param \GSB\Domain\VisitReport $visitReport The visit report to save
     */
    public function save($visitReport) {
        $dateString = $visitReport->getDate()->format('Y-m-d');
        $visitReportData = array(
            'practitioner_id' => $visitReport->getPractitioner()->getId(),
            'visitor_id' => $visitReport->getVisitor()->getId(),
            'reporting_date' => $dateString,
            'purpose' => $visitReport->getPurpose(),
            'assessment' => $visitReport->getAssessment()
            );

        if ($visitReport->getId()) {
            // The visit report has already been saved : update it
            $this->getDb()->update('visit_report', $visitReportData, array('report_id' => $visitReport->getId()));
        } else {
            // The visit report has never been saved : insert it
            $this->getDb()->insert('visit_report', $visitReportData);
            // Get the id of the newly created visit report and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $visitReport->setId($id);
        }
    }

    /**
     * Creates a VisitReport object based on a DB row.
     *
     * @param array $row The DB row containing VisitReport data.
     * @return \GSB\Domain\VisitReport
     */
    protected function buildDomainObject($row) {
        // Find the associated practitioner
        $practitionerId = $row['practitioner_id'];
        $practitioner = $this->practitionerDAO->find($practitionerId);

        // Find the associated visitor
        $visitorId = $row['visitor_id'];
        $visitor = $this->visitorDAO->find($visitorId);

        $visitReport = new VisitReport();
        $visitReport->setId($row['report_id']);
        $visitReport->setDate($row['reporting_date']);
        $visitReport->setPurpose($row['purpose']);
        $visitReport->setAssessment($row['assessment']);
        $visitReport->setPractitioner($practitioner);
        $visitReport->setVisitor($visitor);
        return $visitReport;
    }
}