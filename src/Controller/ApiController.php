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
            return $this->{$parametersAsArray['command']}($parametersAsArray, $request);
        } else {
            throw $this->createNotFoundException();
        }
    }

    protected function venueExists(array $parameters, Request $request) {

    }

    protected function venueAccepting(array $parameters, Request $request) {

    }

    protected function submitRequest(array $parameters, Request $request) {

    }

    protected function search(array $parameters, Request $request) {

    }

    protected function clearDatabase(array $parameters, Request $request) {

    }

    protected function clearRequests(array $parameters, Request $request) {

    }

    protected function clearRequest(array $parameters, Request $request) {

    }

    protected function connectionTest(array $parameters, Request $request) {

    }

    protected function addSongs(array $parameters, Request $request) {

    }

    protected function getSerial(array $parameters, Request $request) {

    }

    protected function getAccepting(array $parameters, Request $request) {

    }

    protected function setAccepting(array $parameters, Request $request) {

    }

    protected function getVenues(array $parameters, Request $request) {

    }

    protected function getRequests(array $parameters, Request $request) {

    }

}
