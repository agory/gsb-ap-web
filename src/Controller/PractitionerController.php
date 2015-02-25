<?php

namespace GSB\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class PractitionerController {

    /**
     * Practitioner details controller.
     *
     * @param integer $id Practitioner id
     * @param Application $app Silex application
     */
    public function practitionerDetailsAction($id, Application $app) {
        $practitioner = $app['dao.practitioner']->find($id);
        return $app['twig']->render('practitioner.html.twig', array('practitioner' => $practitioner));
    }

    /**
     * Practitioners controller.
     *
     * @param Application $app Silex application
     */
    public function practitionersAction(Application $app) {
        $practitioners = $app['dao.practitioner']->findAll();
        return $app['twig']->render('practitioners.html.twig', array('practitioners' => $practitioners));
    }

    /**
     * Practitioner search controller.
     *
     * @param Application $app Silex application
     */
    public function practitionerSearchAction(Application $app) {
        $types = $app['dao.practitionertype']->findAll();
        return $app['twig']->render('practitioners_search.html.twig', array('types' => $types));
    }

    /**
     * Practitioner search results controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function practitionerResultsAction(Request $request, Application $app) {
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
    }
}
