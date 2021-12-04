<?php

// src/Controller/CategoryController.php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/category", name="category_")
*/

class CategoryController extends AbstractController
{
    /**
     * Show all rows from Category's entity
     * 
     * Correspond à la route /category/ et au name "category_index"
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render(
            'category/index.html.twig', 
            ['categories' => $categories]
        );
    }

    /**
     * Correspond à la route /category/{categoryName} et au name "category_show"
     * @Route("/{categoryName}", methods={"GET"}, name="show")
     * * @return Response
     */
    public function show(string $categoryName): Response
    {
        
        $category = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findOneBy(['name' => $categoryName]);
        
        if (!$category) {
            throw $this->createNotFoundException(
                'No category with name : '.$categoryName.' found in category\'s table.'
            );
        }
                
        $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findBy(
            ['category' => $category->getId() ],
            ['id' => 'DESC'], 3
        );
               
        return $this->render('category/show.html.twig', [
            'category' => $category, 
            'programs' => $programs,
        ]);
    }

}