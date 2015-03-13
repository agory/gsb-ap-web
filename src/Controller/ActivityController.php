<?php

namespace GSB\Controller;

use GSB\Domain\Activity;
use GSB\Form\Type\ActivityType;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ActivityController {

    /**
     * Activities controller.
     *
     * @param Application $app Silex application
     */
    public function activitiesAction(Application $app) {
        $activities = $app['dao.activity']->findAll();
        return $app['twig']->render('activities.html.twig', array('activities' => $activities));
    }
    
    /**
     * Activity details controller.
     *
     * @param integer $id activity id
     * @param Application $app Silex application
     */
    public function activityDetailsAction($id, Application $app) {
        $activity = $app['dao.activity']->find($id);
        return $app['twig']->render('activity.html.twig', array('activity' => $activity));
    }

    /**
     * Add activity controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function addActivityAction(Request $request, Application $app) {
        $activity = new Activity();
        $form = new ActivityType();
        $activityForm = $app['form.factory']->create($form, $activity);        
        $activityForm->handleRequest($request);
        if ($activityForm->isValid()) {
            $app['dao.activity']->save($activity);
            $app['session']->getFlashBag()->add('success', 'Votre activité a été ajouté.');
        }
        return $app['twig']->render('activity_form.html.twig', array(
                    'title' => 'Nouvelle activitée',
                    'activityForm' => $activityForm->createView(),
        ));
    }
    
    /**
     * Edit activity controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function editActivityAction($id, Request $request, Application $app) {
        $activity = $app['dao.activity']->find($id);
        $form = new ActivityType();
        $activityForm = $app['form.factory']->create($form, $activity);        
        $activityForm->handleRequest($request);
        if ($activityForm->isValid()) {
            $app['dao.activity']->save($activity);
            $app['session']->getFlashBag()->add('success', 'Votre activité a été mis à jour.');
        }
        return $app['twig']->render('activity_form.html.twig', array(
                    'title' => 'Modifier une activitée',
                    'activityForm' => $activityForm->createView(),
        ));
    }

}
