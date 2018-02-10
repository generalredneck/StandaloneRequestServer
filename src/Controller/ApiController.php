<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        } else {
            return new JsonResponse(
                ["errorString" => "Invalid Request", "error" => true],
                Response::HTTP_BAD_REQUEST
            );
        }
        $api_key = getenv('API_KEY');
        if (empty($api_key)  || empty($parametersAsArray['api_key']) || $parametersAsArray['api_key'] != $api_key) {
            return new JsonResponse(
                ["errorString" => "Unauthorized", "error" => true],
                Response::HTTP_UNAUTHORIZED
            );
        }
        if (!empty($parametersAsArray['command']) && method_exists($this, $parametersAsArray['command'])) {
            return $this->{$parametersAsArray['command']}($parametersAsArray, $request);
        } else {
            return new JsonResponse(
                ["errorString" => "Command Not Found", "error" => true],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    protected function venueExists(array $parameters, Request $request) {
        $venue_name = getenv('VENUE_NAME');
        // Looks like the old server used the URLName "none".
        return new JsonResponse([
            'exists' => !empty($venue_name) && !empty($parameters['venueUrlName']) && $venue_name == $parameters['venueUrlName'],
            'command' => $parameters['command'],
            'error' => false
        ]);
    }

    protected function venueAccepting(array $parameters, Request $request) {
        return new JsonResponse([
            'accepting' => true,
            'command' => $parameters['command'],
            'error' => false
        ]);
    }

    protected function submitRequest(array $parameters, Request $request) {
        return new JsonResponse([
            'success' => true,
            'command' => $parameters['command'],
            'error' => false
        ]);
    }

    protected function search(array $parameters, Request $request) {
        return new JsonResponse([
            'songs' => [["song_id" => 'song_id', "artist_title" => "artist_title", "title" => "title"]],
            'command' => $parameters['command'],
            'error' => false
        ]);
    }

    protected function clearDatabase(array $parameters, Request $request) {
        return new JsonResponse([
            'serial' => 1234,
            'command' => $parameters['command'],
            'error' => false
        ]);
    }

    protected function clearRequests(array $parameters, Request $request) {
        return new JsonResponse([
            'serial' => 1234,
            'command' => $parameters['command'],
            'error' => false
        ]);
    }

    protected function clearRequest(array $parameters, Request $request) {
        return new JsonResponse([
            'serial' => 1234,
            'command' => $parameters['command'],
            'error' => false
        ]);
    }

    protected function connectionTest(array $parameters, Request $request) {
        return new JsonResponse([
            'connection' => 'ok',
            'command' => $parameters['command'],
            'error' => false
        ]);
    }

    protected function addSongs(array $parameters, Request $request) {
        return new JsonResponse([
            'command' => $parameters['command'],
            'error' => false,
            'errors' => [['HY000', '1', 'near "bogus": syntax error']],
            'entries processed' => 100,
            'last_artist' => 'artist',
            'last_title' => 'title'
        ]);
    }

    protected function getSerial(array $parameters, Request $request) {
        return new JsonResponse([
            'serial' => 1234,
            'command' => $parameters['command'],
            'error' => false
        ]);
    }

    protected function getAccepting(array $parameters, Request $request) {
        return new JsonResponse([
            'accepting' => true,
            'venue_id' => 0,
            'command' => $parameters['command'],
            'error' => false
        ]);
    }

    protected function setAccepting(array $parameters, Request $request) {
        return new JsonResponse([
            'accepting' => true,
            'venue_id' => 0,
            'serial' => 1234,
            'command' => $parameters['command'],
            'error' => false
        ]);
    }

    protected function getVenues(array $parameters, Request $request) {
        return new JsonResponse([
            'command' => $parameters['command'],
            'error' => false
            'venues' => [
                [
                    'venue_id' => 0,
                    'accepting' => true,
                    'name' => 'venue name',
                    'url_name' => 'none'
                ]
            ]
        ]);
        $venue['venue_id'] = 0;
        $venue['accepting'] = getAccepting();
        $venue['name'] = $venueName;
        $venue['url_name'] = "none";
    }

    protected function getRequests(array $parameters, Request $request) {
        return new JsonResponse([
            'serial' => 1234,
            'command' => $parameters['command'],
            'error' => false,
            'requests' => [
                [
                    'request_id' => 123,
                    'artist' => 'artist',
                    'title' => 'title',
                    'singer' => 'singer',
                    'request_time' => 1412332432
                ]
            ]
        ]);
    }

}
