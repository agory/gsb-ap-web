<?php

use Symfony\Component\HttpFoundation\Request;
use GSB\Domain\VisitReport;
use GSB\Form\Type\VisitorType;
use GSB\Form\Type\VisitReportType;

// Home page
$app->get('/', "GSB\Controller\HomeController::indexAction");

// Details for a drug
$app->get('/drugs/{id}', "GSB\Controller\DrugController::drugDetailsAction");

// List of all drugs
$app->get('/drugs/', "GSB\Controller\DrugController::drugsAction");

// Search form for drugs
$app->get('/drugs/search/', "GSB\Controller\DrugController::drugSearchAction");

// Results page for drugs
$app->post('/drugs/results/', "GSB\Controller\DrugController::drugResultsAction");

// Details for a practitioner
$app->get('/practitioners/{id}', "GSB\Controller\PractitionerController::practitionerDetailsAction");

// List of all practitioners
$app->get('/practitioners/', "GSB\Controller\PractitionerController::practitionersAction");

// Search form for practitioners
$app->get('/practitioners/search/', "GSB\Controller\PractitionerController::practitionerSearchAction");

// Results page for practitioners
$app->post('/practitioners/results/', "GSB\Controller\PractitionerController::practitionerResultsAction");

// Login form
$app->get('/login', "GSB\Controller\HomeController::loginAction")->bind('login');  // named route so that path('login') works in Twig templates

// Personal info
$app->match('/me', "GSB\Controller\VisitorController::profileAction");

// List of all visit reports for the current visitor
$app->get('/reports/', "GSB\Controller\VisitReportController::visitReportsAction");

// New visit report
$app->match('/reports/add/', "GSB\Controller\VisitReportController::addVisitReportAction");
