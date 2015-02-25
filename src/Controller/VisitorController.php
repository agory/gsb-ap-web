<?php

namespace GSB\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use GSB\Form\Type\VisitorType;

class VisitorController {

    /**
     * Visitor profile controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function profileAction(Request $request, Application $app) {
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
    }
}
