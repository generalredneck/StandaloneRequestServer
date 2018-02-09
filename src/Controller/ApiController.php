<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    /**
     * @Route("/api", name="api")
     */
    public function index(Request $request)
    {
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }
        if (!empty($parametersAsArray['command']) && method_exists($this, $parametersAsArray['command'])) {
            return $this->{$parametersAsArray['command']};
        } else {
            throw $this->createNotFoundException();
        }
    }


}
