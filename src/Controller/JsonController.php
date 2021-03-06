<?php

namespace GSB\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonController {

    public function setPractitionerAction(Request $request, Application $app) {
        $result = FALSE;
        if ($request->getContent()) {
            $data = json_decode($request->getContent(), true);
            $practitioner = $app['dao.practitioner']->convertJsonObject($data);
            //$app['monolog']->addInfo(var_export($practitioner, true));
            $app['dao.practitioner']->save($practitioner);
            $result = TRUE;
        }
        return $this->jsonResponse($result);
    }

    public function practitionerTypesAction(Request $request, Application $app) {
        $types = $app['dao.practitionertype']->findAll();
        return $this->jsonResponse($types);
        
    }

    public function practitionerAction($id, Request $request, Application $app) {
        $practitioner = $app['dao.practitioner']->find($id);
        return $this->jsonResponse($practitioner);
        
    }

    public function practitionersAction(Request $request, Application $app) {
        $practitioners = $app['dao.practitioner']->findAll();
        return $this->jsonResponse($practitioners);
        
    }

    
    /* PMAZI */
    // List
    public function activityListAction(Application $app) {
        $activities = $app['dao.activity']->findAll();
        return $this->jsonResponse($activities);
    }

    // Detail
    public function activityDetailAction($id, Request $request, Application $app) {
        $activity = $app['dao.activity']->find($id);
        return $this->jsonResponse($activity);
    }
   
    // TODO fonction add
     public function setActivityAction(Request $request, Application $app) {
        $result = FALSE;
        if ($request->getContent()) {            
            $data = json_decode($request->getContent(), true);            
            $activity = $app['dao.activity']->convertJsonObject($data);
            $app['dao.activity']->save($activity);
            $result = TRUE;
        }
        return $this->jsonResponse($result);
    }

    
    private function jsonResponse($data) {
        $response = new Response(json_encode($data, JSON_FORCE_OBJECT));
        $response->headers->set('Content-type', 'application/json');
        $response->headers->set("Access-Control-Allow-Origin", "*");
        $response->headers->set("Access-Control-Allow-Methods", "GET, POST, OPTIONS");
        $response->headers->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
        return $response;
    }

}
