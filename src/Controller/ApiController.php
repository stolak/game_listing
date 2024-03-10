<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class ApiController extends AbstractController
{
    private $params;
    private $apiUrl;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
        $this->apiUrl="https://casino-games-api.united-remote.dev/games";
    }

    /**
     * @Route("/", name="api")
     */
    public function index(): Response
    {
        
        // $apiUrl = $this->params->get('api_url');

        try {
            // Create an HTTP client
            $client = HttpClient::create();
            
            // Send a GET request to the API endpoint
            $response = $client->request('GET', $this->apiUrl);
        
            // Check for successful response
            if ($response->getStatusCode() === 200) {
                // Convert response to an array
                $games = $response->toArray();
        
                // Render the data in the template
                return $this->render('api/index.html.twig', [
                    'games' => $games,
                ]);
            } else {
                // Render an empty array if the response status code is not 200
                return $this->render('api/index.html.twig', [
                    'games' => [],
                ]);
            }
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the request
            return $this->render('api/index.html.twig', [
                'games' => [],
            ]);
        }
    }
}
