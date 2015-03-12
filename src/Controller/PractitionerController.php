<?php

namespace GSB\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use GSB\Domain\Practitioner;
use GSB\Form\Type\PractitionerType;

class PractitionerController {

    /**
     * Practitioner details controller.
     *
     * @param integer $id Practitioner id
     * @param Application $app Silex application
     */
    public function practitionerDetailsAction($id, Application $app) {
        $practitioner = $app['dao.practitioner']->find($id);
        $practitioner->setLineSpecialites($app['dao.specialite']->findAllByPractitioner($practitioner));
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
        } else {
            // Advanced search by name and city
            $name = $request->request->get('name');
            $city = $request->request->get('city');
            $practitioners = $app['dao.practitioner']->findAllByNameAndCity($name, $city);
        }
        return $app['twig']->render('practitioners_results.html.twig', array('practitioners' => $practitioners));
    }

    /**
     * Add visit report controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addPractitionerAction(Request $request, Application $app) {
        $practitionerFormView = NULL;
        $practitioner = new Practitioner();
        $practitionerForm = $this->formCreate($request,$app,$practitioner,'Votre practicien a été ajouté.');
        $practitionerFormView = $practitionerForm->createView();
        return $app['twig']->render('practitioner_form_new.html.twig', array(
                    'practitionerForm' => $practitionerFormView,
                    'title' => 'Nouveau practicien'
        ));
    }

    public function editPractitionerAction($id, Request $request, Application $app) {
        $practitionerFormView = NULL;
        $practitioner = $app['dao.practitioner']->find($id);
        $practitionerForm = $this->formCreate($request,$app,$practitioner,'Votre practicien a été ajouté.');
        $practitionerFormView = $practitionerForm->createView();
        return $app['twig']->render('practitioner_form.html.twig', array(
                    'practitionerForm' => $practitionerFormView,
                    'title' => 'Edit practicien',
                    'formMenu' => 0
        ));
    }
    
    private function formCreate(Request $request,Application $app,Practitioner $practitioner, $msg){
        $types = $app['dao.practitionertype']->findAll();
        $practitionerForm = $app['form.factory']->create(new PractitionerType($types), $practitioner);
        $practitionerForm->handleRequest($request);
        if ($practitionerForm->isValid()) {
            // Manually affect practitioner to the new visit report
            $typeId = $practitionerForm->get('type')->getData();
            $type = $app['dao.practitionertype']->find($typeId);
            $practitioner->setType($type);
            $app['dao.practitioner']->save($practitioner);
            $app['session']->getFlashBag()->add('success', $msg);
        }
        return $practitionerForm;
    }

}
