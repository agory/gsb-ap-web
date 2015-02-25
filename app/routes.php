<?php

use Symfony\Component\HttpFoundation\Request;
use GSB\Domain\VisitReport;
use GSB\Form\Type\VisitorType;
use GSB\Form\Type\VisitReportType;

// Home page
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig');
});

// Details for a drug
$app->get('/drugs/{id}', function($id) use ($app) {
    $drug = $app['dao.drug']->find($id);
    return $app['twig']->render('drug.html.twig', array('drug' => $drug));
});

// List of all drugs
$app->get('/drugs/', function() use ($app) {
    $drugs = $app['dao.drug']->findAll();
    return $app['twig']->render('drugs.html.twig', array('drugs' => $drugs));
});

// Search form for drugs
$app->get('/drugs/search/', function() use ($app) {
    $families = $app['dao.family']->findAll();
    return $app['twig']->render('drugs_search.html.twig', array('families' => $families));
});

// Results page for drugs
$app->post('/drugs/results/', function(Request $request) use ($app) {
    $familyId = $request->request->get('family');
    $drugs = $app['dao.drug']->findAllByFamily($familyId);
    return $app['twig']->render('drugs_results.html.twig', array('drugs' => $drugs));
});

// Details for a practitioner
$app->get('/practitioners/{id}', function($id) use ($app) {
    $practitioner = $app['dao.practitioner']->find($id);
    return $app['twig']->render('practitioner.html.twig', array('practitioner' => $practitioner));
});

// List of all practitioners
$app->get('/practitioners/', function() use ($app) {
    $practitioners = $app['dao.practitioner']->findAll();
    return $app['twig']->render('practitioners.html.twig', array('practitioners' => $practitioners));
});

// Search form for practitioners
$app->get('/practitioners/search/', function() use ($app) {
    $types = $app['dao.practitionertype']->findAll();
    return $app['twig']->render('practitioners_search.html.twig', array('types' => $types));
});

// Results page for practitioners
$app->post('/practitioners/results/', function(Request $request) use ($app) {
    if ($request->request->has('type')) {
        // Simple search by type
        $typeId = $request->request->get('type');
        $practitioners = $app['dao.practitioner']->findAllByType($typeId);
    }
    else {
        // Advanced search by name and city
        $name = $request->request->get('name');
        $city = $request->request->get('city');
        $practitioners = $app['dao.practitioner']->findAllByNameAndCity($name, $city);
    }
    return $app['twig']->render('practitioners_results.html.twig', array('practitioners' => $practitioners));
});

// Login form
$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
        ));
})->bind('login');  // named route so that path('login') works in Twig templates

// Personal info
$app->match('/me', function(Request $request) use ($app) {
    $visitor = $app['security']->getToken()->getUser();
    $visitorFormView = NULL;
    $visitorForm = $app['form.factory']->create(new VisitorType(), $visitor);
    $visitorForm->handleRequest($request);
    if ($visitorForm->isValid()) {
        $plainPassword = $visitor->getPassword();
        // find the encoder for a UserInterface instance
        $encoder = $app['security.encoder_factory']->getEncoder($visitor);
        // compute the encoded password
        $password = $encoder->encodePassword($plainPassword, $visitor->getSalt());
        $visitor->setPassword($password); 
        $app['dao.visitor']->save($visitor);
        $app['session']->getFlashBag()->add('success', 'Vos informations personnelles ont été mises à jour.');
    }
    $visitorFormView = $visitorForm->createView();
    return $app['twig']->render('visitor.html.twig', array('visitorForm' => $visitorFormView));
});

// List of all visit reports for the current visitor
$app->get('/reports/', function() use ($app) {
    $visitor = $app['security']->getToken()->getUser();
    $visitorId = $visitor->getId();
    $visitReports = $app['dao.visitreport']->findAllByVisitor($visitorId);
    return $app['twig']->render('visitreports.html.twig', array('visitReports' => $visitReports));
});

// New visit report
$app->match('/reports/add/', function(Request $request) use ($app) {
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
});
