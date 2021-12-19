<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/season", name="season_")
*/
class SeasonController extends AbstractController
{
    /**
     * Show all rows from Season's entity
     * Correspond à la route /season/ et au name "season_index"
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findAll();
        return $this->render(
            'season/index.html.twig', 
            ['seasons' => $seasons]
        );
    }
}
