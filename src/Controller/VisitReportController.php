<?php

namespace GSB\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use GSB\Domain\VisitReport;
use GSB\Form\Type\VisitReportType;

class VisitReportController {

    /**
     * Visit reports controller.
     *
     * @param Application $app Silex application
     */
    public function visitReportsAction(Application $app) {
        $visitor = $app['security']->getToken()->getUser();
        $visitorId = $visitor->getId();
        $visitReports = $app['dao.visitreport']->findAllByVisitor($visitorId);
        return $app['twig']->render('visitreports.html.twig', array('visitReports' => $visitReports));
    }

    /**
     * Add visit report controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addVisitReportAction(Request $request, Application $app) {
        $visitor = $app['security']->getToken()->getUser();
        $visitReportFormView = NULL;
        $visitReport = new VisitReport();
        $visitReport->setVisitor($visitor);
        $practitioners = $app['dao.practitioner']->findAll();
        $visitReportForm = $app['form.factory']->create(new VisitReportType($practitioners), $visitReport);
        $visitReportForm->handleRequest($request);
        if ($visitReportForm->isValid()) {
            // Manually affect practitioner to the new visit report
            $practitionerId = $visitReportForm->get('practitioner')->getData();
            $practitioner = $app['dao.practitioner']->find($practitionerId);
            $visitReport->setPractitioner($practitioner);
            $app['dao.visitreport']->save($visitReport);
            $app['session']->getFlashBag()->add('success', 'Votre rapport de visite a été ajouté.');
        }
        $visitReportFormView = $visitReportForm->createView();
        return $app['twig']->render('visitreport.html.twig', array('visitReportForm' => $visitReportFormView));
    }
}
