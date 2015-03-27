<?php

namespace GSB\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class JsonController {

    public function practitionerAction($id, Request $request, Application $app) {
        $practitioner = $app['dao.practitioner']->find($id);
        return json_encode($practitioner, JSON_FORCE_OBJECT);
    }
    
    public function practitionersAction(Request $request, Application $app) {
        $practitioners = $app['dao.practitioner']->findAll();
        return json_encode($practitioners, JSON_FORCE_OBJECT);
    }

}
