<?php

// namespace App\Controller;

// use App\Repository\FilmRepository; // Assuming you have a Film entity and repository
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;

// class FilmController extends AbstractController
// {
//     #[Route('/film', name: 'app_film')]
//     public function index(FilmRepository $filmRepository): Response
//     {
//         // Fetch films from the database (assuming you have a Film entity)
//         $films = $filmRepository->findAll();

//         // Pass the films to the template
//         return $this->render('film/index.html.twig', [
//             'films' => $films,
//         ]);
//     }
// }



namespace App\Controller;

use App\Entity\Cinema;
use App\Entity\Reservation;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;  // Make sure Response is imported
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    #[Route('/film', name: 'app_film')]
    public function index(FilmRepository $filmRepository): Response
    {
        // Fetch films from the database
        $films = $filmRepository->findAll();

        // Pass the films to the template
        return $this->render('film/index.html.twig', [
            'films' => $films,
        ]);
    }

    #[Route('/reservation/add', name: 'add_reservation', methods: ['POST'])]
    public function addReservation(
        Request $request,
        FilmRepository $filmRepository,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // Validate required data and types
        if (!isset($data['film_id']) || !is_numeric($data['film_id'])) {
            return new JsonResponse(['error' => 'Valid Film ID is required'], 400);
        }
        if (!isset($data['cinema_id']) || !is_numeric($data['cinema_id'])) {
            return new JsonResponse(['error' => 'Valid Cinema ID is required'], 400);
        }

        // Fetch the film entity
        $film = $filmRepository->find($data['film_id']);
        if (!$film) {
            return new JsonResponse(['error' => 'Film not found'], 404);
        }

        // Fetch the authenticated client
        $client = $this->getUser();
        if (!$client) {
            return new JsonResponse(['error' => 'User not authenticated'], 403);
        }

        // Fetch the cinema
        $cinema = $em->getRepository(Cinema::class)->find($data['cinema_id']);
        if (!$cinema) {
            return new JsonResponse(['error' => 'Cinema not found'], 404);
        }

        // Create the reservation
        $reservation = new Reservation();
        $reservation->setFilm($film);
        $reservation->setCinema($cinema);
        $reservation->setClient($client);
        $reservation->setDateReservation(new \DateTimeImmutable());

        // Save the reservation
        $em->persist($reservation);
        $em->flush();

        // Return success message along with the created reservation data
        return new JsonResponse([
            'message' => 'Reservation added successfully',
            'reservation' => [
                'film_id' => $reservation->getFilm()->getId(),
                'cinema_id' => $reservation->getCinema()->getId(),
                'client_id' => $reservation->getClient()->getId(),
                'date_reservation' => $reservation->getDateReservation()->format('Y-m-d H:i:s')
            ]
        ], 201);
    }
}


