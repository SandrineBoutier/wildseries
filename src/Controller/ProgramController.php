<?php

// src/Controller/ProgramController.php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Category;
use App\Entity\Season;
use App\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
* @Route("/program", name="program_")
*/

class ProgramController extends AbstractController
{
    /**
     * Show all rows from Program's entity
     * 
     * Correspond à la route /program/ et au name "program_index"
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render(
            'program/index.html.twig', 
            ['programs' => $programs]
        );
    }
    
    /**
     * Correspond à la route /program/show/{id} et au name "program_show"
     * @Route("/show/{id}", methods={"GET"},  name="show")
     * * @return Response
     */
    public function show(Program $program): Response
    {   
        $seasons = $program->getSeasons();
                
        return $this->render('program/show.html.twig', [
            'program' => $program,'seasons'=> $seasons
        ]);
    }

    /**
     * Correspond à la route /program/{program}/seasons/{season} et au name "program_season_show"
     * @Route("/{program}/seasons/{season}", methods={"GET"},  name="season_show")
     * @return Response
     */
    public function showSeason(Program $program, Season $season): Response
    {
        $episodes = $season->getEpisodes();
        
        return $this->render('program/season_show.html.twig', ['program'=> $program, 'season'=>$season, 'episodes'=>$episodes]);
    }

    /**
     * Correspond à la route /program/{programId}/season/{seasonId}/episode/{episodeId} et au name "program_episode_show"
     * @Route("/{program_id}/season/{season_id}/episode/{episode_id}", methods={"GET"},  name="episode_show")
     * @ParamConverter("program", class="App\Entity\Program",options={"mapping":{"program_id": "id"}})
     * @ParamConverter("season", class="App\Entity\Season",options={"mapping":{"season_id": "id"}})
     * @ParamConverter("episode", class="App\Entity\Episode",options={"mapping":{"episode_id": "id"}})
     * @return Response
     */
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', ['program'=> $program, 'season'=>$season, 'episode'=>$episode]);
    }
}