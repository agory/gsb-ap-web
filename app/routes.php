<?php

use Symfony\Component\HttpFoundation\Request;
use GSB\Domain\VisitReport;
use GSB\Form\Type\VisitorType;
use GSB\Form\Type\VisitReportType;
use GSB\Form\Type\ActivityType;

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

// add practitioners
$app->match('/practitioners/add/', "GSB\Controller\PractitionerController::addPractitionerAction");

// edit practitioners
$app->match('/practitioners/edit/{id}', "GSB\Controller\PractitionerController::editPractitionerAction");

// edit spe practitioners
$app->match('/practitioners/edit/{id}/spe', "GSB\Controller\PractitionerController::gestSpePractitionerAction");

// del spe practitioners
$app->match('/practitioners/edit/{idPractitioner}/spe/{idSpecialite}/del', "GSB\Controller\PractitionerController::delSpePractitionerAction");

// Login form
$app->get('/login', "GSB\Controller\HomeController::loginAction")->bind('login');  // named route so that path('login') works in Twig templates

// Personal info
$app->match('/me', "GSB\Controller\VisitorController::profileAction");

// List of all visit reports for the current visitor
$app->get('/reports/', "GSB\Controller\VisitReportController::visitReportsAction");

// New visit report
$app->match('/reports/add/', "GSB\Controller\VisitReportController::addVisitReportAction");


/* * * * * * * * * * *
* 
* COMMERCIAL - Pierre
* 
* * * * * * * * * * */

// List of all activities
$app->get('/activities/', "GSB\Controller\ActivityController::activitiesAction");

// Details for a activite
$app->get('/activities/{id}', "GSB\Controller\ActivityController::activityDetailsAction");

// Add activities
$app->match('/activities/add/', "GSB\Controller\ActivityController::addActivityAction");

// Edit activities
$app->match('/activities/edit/{id}', "GSB\Controller\ActivityController::editActivityAction");


/* * * * * * * * * * *
* 
* Web Service - Alexandre
* 
* * * * * * * * * * */

// Details for a practitioner
$app->get('/json/practitioners/{id}', "GSB\Controller\JsonController::practitionerAction");

// List of all practitioners
$app->get('/json/practitioners/all/', "GSB\Controller\JsonController::practitionersAction");

// List of all practitioner type
$app->get('/json/practitioners/type/all/', "GSB\Controller\JsonController::practitionerTypesAction");

// List of all practitioner type
$app->match('/json/practitioners/set/', "GSB\Controller\JsonController::setPractitionerAction");


/* * * * * * * * * * *
* 
* Web Service - Pierre
* 
* * * * * * * * * * */

// List of all activities
$app->get('/json/activities/', "GSB\Controller\JsonController::activityListAction");

// Detail for an activity
$app->get('/json/activity/{id}', "GSB\Controller\JsonController::activityDetailAction");