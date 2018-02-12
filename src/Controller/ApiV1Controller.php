<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Setting;
use App\Entity\Request as SongRequest;

class ApiV1Controller extends Controller
{
    /**
     * @Route("/api/v1", name="apiv1")
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
        // Looks like the old server used the URLName "none".
        return new JsonResponse([
            'exists' => !empty($parameters['venueUrlName']) && 'none' == $parameters['venueUrlName'],
            'command' => $parameters['command'],
            'error' => false
        ]);
    }

    protected function venueAccepting(array $parameters, Request $request) {
        return $this->getAccepting($parameters, $request);
    }

    protected function submitRequest(array $parameters, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $state = $em->getRepository(Setting::class)->find('accepting_state');
        if (!$state->value) {
            return new JsonResponse(
                ["errorString" => "This venue is not accepting requests right now.", "error" => true],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $song_id = $parameters['songId'];
        if (empty($song_id) || !is_int($song_id)) {
            return new JsonResponse(
                ["errorString" => "Invalid Song Request", "error" => true],
                Response::HTTP_BAD_REQUEST
            );
        }
        $song = $em->getRepository(Song::class)->find($song_id);
        $singer_name = $data['singerName'];
        $song_request = new SongRequest();
        $song_request->singer = $singer_name;
        $song_request->artist = $song->artist;
        $song_request->title = $song->title;
        $em->persist($song_request);
        $em->flush();
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
        $state = $this->getDoctrine()->getRepository(Setting::class)->find('accepting_state');
        return new JsonResponse([
            'accepting' => (bool) $state->value,
            'venue_id' => 0,
            'command' => $parameters['command'],
            'error' => false
        ]);
    }

    protected function setAccepting(array $parameters, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $state = $em->getRepository(Setting::class)->find('accepting_state');
        $state->value = (bool) $parameters['accepting'];
        $em->flush();
        return new JsonResponse([
            'accepting' => (bool) $state->value,
            'venue_id' => 0,
            'command' => $parameters['command'],
            'error' => false
        ]);
    }

    protected function getVenues(array $parameters, Request $request) {
        $state = $this->getDoctrine()->getRepository(Setting::class)->find('accepting_state');
        $venue_name = getenv('VENUE_NAME');
        return new JsonResponse([
            'command' => $parameters['command'],
            'error' => false,
            'venues' => [
                [
                    'venue_id' => 0,
                    'accepting' => (bool) $state->value,
                    'name' => $venue_name,
                    'url_name' => 'none'
                ]
            ]
        ]);
    }

    protected function getRequests(array $parameters, Request $request) {
        $requests = $this->getDoctrine()->getRepository(Request::class)->findAll();
        $response_data = [
            'command' => $parameters['command'],
            'error' => false,
            'requests' => []
        ];
        foreach ($requests as $song_request) {
            $response_data['requests'][] = [
                'request_id' => $song_request->id,
                'artist' => $song_request->artist,
                'title' => $song_request->title,
                'singer' => $song_request->singer,
                'request_time' => $song_request->request_time->getTimestamp(),
            ];
        }
        return new JsonResponse($response_data);
    }

}
