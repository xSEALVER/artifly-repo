<?php

// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Attribute\Route;

// class FilmController extends AbstractController
// {
//     #[Route('/film', name: 'app_film')]
//     public function index(): Response
//     {
//         return $this->render('film/index.html.twig', [
//             'controller_name' => 'FilmController',
//         ]);
//     }
// }

// src/Controller/FilmController.php

namespace App\Controller;

use App\Repository\FilmRepository; // Assuming you have a Film entity and repository
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    #[Route('/film', name: 'app_film')]
    public function index(FilmRepository $filmRepository): Response
    {
        // Fetch films from the database (assuming you have a Film entity)
        $films = $filmRepository->findAll();

        // Pass the films to the template
        return $this->render('film/index.html.twig', [
            'films' => $films,
        ]);
    }
}
