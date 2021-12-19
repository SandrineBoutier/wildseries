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
     * @Route("/show/{id<^[0-9]+$>}", methods={"GET"},  name="show")
     * * @return Response
     */
    public function show(int $id): Response
    {
        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy(['id' => $id]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        
        $seasons = $program->getSeasons();
        
        if(!$seasons){
            throw $this->createNotFoundException(
                'No season with id : '.$id.' found in season\'s table.'
            );
        }
                
        return $this->render('program/show.html.twig', [
            'program' => $program,'seasons'=> $seasons
        ]);
    }

    /**
     * Correspond à la route /program/{programId}/seasons/{seasonId} et au name "program_season_show"
     * @Route("/{programId}/seasons/{seasonId}", methods={"GET"},  name="season_show")
     * @return Response
     */
    public function showSeason(int $programId, int $seasonId): Response
    {
        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy(['id' => $programId]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$programId.' found in program\'s table.'
            );
        }
        
        $season = $this->getDoctrine()
        ->getRepository(Season::class)
        ->findOneBy(['id' => $seasonId]);
    
        if (!$season) {
            throw $this->createNotFoundException(
                'No season with id : '.$seasonId.' found in season\'s table.'
            );    
        }

        $episodes = $season->getEpisodes();
        
        return $this->render('program/season_show.html.twig', ['program'=> $program, 'season'=>$season, 'episodes'=>$episodes]);
    }
}