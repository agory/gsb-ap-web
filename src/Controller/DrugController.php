<?php

namespace GSB\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class DrugController {

    /**
     * Drug details controller.
     *
     * @param integer $id Drug id
     * @param Application $app Silex application
     */
    public function drugDetailsAction($id, Application $app) {
        $drug = $app['dao.drug']->find($id);
        return $app['twig']->render('drug.html.twig', array('drug' => $drug));
    }

    /**
     * Drugs controller.
     *
     * @param Application $app Silex application
     */
    public function drugsAction(Application $app) {
        $drugs = $app['dao.drug']->findAll();
        return $app['twig']->render('drugs.html.twig', array('drugs' => $drugs));
    }

    /**
     * Drug search controller.
     *
     * @param Application $app Silex application
     */
    public function drugSearchAction(Application $app) {
        $families = $app['dao.family']->findAll();
        return $app['twig']->render('drugs_search.html.twig', array('families' => $families));
    }

    /**
     * Drug search results controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function drugResultsAction(Request $request, Application $app) {
        $familyId = $request->request->get('family');
        $drugs = $app['dao.drug']->findAllByFamily($familyId);
        return $app['twig']->render('drugs_results.html.twig', array('drugs' => $drugs));
    }
}
