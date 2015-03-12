<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app['twig'] = $app->share($app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
}));
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'login' => array(
            'pattern' => '^/login$',
            'anonymous' => true
        ),
        'secured' => array(
            'pattern' => '^.*$',
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'users' => $app->share(function () use ($app) {
                return new GSB\DAO\VisitorDAO($app['db']);
            }),
        ),
    ),
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => __DIR__.'/../var/logs/gsb.log',
    'monolog.name' => 'GSB',
    'monolog.level' => $app['monolog.level']
));

// Register services.
$app['dao.family'] = $app->share(function ($app) {
    return new GSB\DAO\FamilyDAO($app['db']);
});
$app['dao.drug'] = $app->share(function ($app) {
    $drugDAO = new GSB\DAO\DrugDAO($app['db']);
    $drugDAO->setFamilyDAO($app['dao.family']);
    return $drugDAO;
});
$app['dao.practitionertype'] = $app->share(function ($app) {
    return new GSB\DAO\PractitionerTypeDAO($app['db']);
});
$app['dao.practitioner'] = $app->share(function ($app) {
    $practitionerDAO = new GSB\DAO\PractitionerDAO($app['db']);
    $practitionerDAO->setPractitionerTypeDAO($app['dao.practitionertype']);
    return $practitionerDAO;
});
$app['dao.visitor'] = $app->share(function ($app) {
    return new GSB\DAO\VisitorDAO($app['db']);
});
$app['dao.visitreport'] = $app->share(function ($app) {
    $visitReportDAO = new GSB\DAO\VisitReportDAO($app['db']);
    $visitReportDAO->setPractitionerDAO($app['dao.practitioner']);
    $visitReportDAO->setVisitorDAO($app['dao.visitor']);
    return $visitReportDAO;
});

$app['dao.specialite'] = $app->share(function ($app) {
    $specialiteDAO = new GSB\DAO\SpecialiteDAO($app['db']);
    return $specialiteDAO;
});

// Register JSON data decoder for JSON requests
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});
