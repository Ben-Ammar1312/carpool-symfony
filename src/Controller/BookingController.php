<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\PickupPoint;
use App\Enum\Etat;
use App\Enum\Status;
use App\Repository\AnnonceRepository;
use App\Repository\PickupPointRepository;
use App\Repository\UtilisateurRepository;
use App\Service\NotificationService;
use App\Service\ReservationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class BookingController extends AbstractController
{
    private $annonceRepository;
    private $pickPointRepository;
    private $notificationService;

    public function __construct(
        ReservationService $reservationService,
        UtilisateurRepository $userRepository,
        AnnonceRepository $annonceRepository,
        PickupPointRepository $pickPointRepository,
        NotificationService $notificationService
    ) {
        $this->reservationService = $reservationService;
        $this->userRepository = $userRepository;
        $this->annonceRepository = $annonceRepository;
        $this->pickPointRepository = $pickPointRepository;
        $this->notificationService = $notificationService;
    }

    /**
     * @Route("/bookRide", name="book_ride", methods={"POST"})
     */
    public function bookRide(Request $request, Security $security): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $security->getUser();
        if (!$user || !$user instanceof \App\Entity\Passager) {
            return $this->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $passager = $user;
        $annonce = $this->annonceRepository->find($data['annonceId']);

        if (!$annonce) {
            return $this->json(['message' => 'Annonce not found'], Response::HTTP_BAD_REQUEST);
        }

        if ($annonce->getNbrPlaces() <= 0) {
            return $this->json(['message' => 'This ride is fully booked'], Response::HTTP_BAD_REQUEST);
        }

        $requestedSeats = 1; // Assume one seat per booking

        $reservation = new Reservation();
        $reservation->setPassager($passager)
            ->setAnnonce($annonce)
            ->setNbrPlaces($requestedSeats)
            ->setDateReservation(new \DateTime());

        if ($data['onRoute']) {
            if ($annonce->getNbrPlaces() < $requestedSeats) {
                return $this->json(['message' => 'Not enough seats available'], Response::HTTP_BAD_REQUEST);
            }

            $pickupPoint = new PickupPoint();
            $pickupPoint->setLatitude($data['pickupLat'])
                ->setLongitude($data['pickupLng'])
                ->setAnnonce($annonce);

            $this->pickPointRepository->save($pickupPoint);

            if (strtolower($data['paymentMethod']) === 'cash') {
                $reservation->setEtat(Etat::VALIDE);
                $this->reservationService->save($reservation);

                $annonce->setNbrPlaces($annonce->getNbrPlaces() - $requestedSeats);
                if ($annonce->getNbrPlaces() <= 0) {
                    $annonce->setStatus(Status::FULL);
                }
                $this->annonceRepository->save($annonce);

                return $this->json(['message' => 'Booking confirmed (Cash Payment)']);
            } else {
                $reservation->setEtat(Etat::PAYMENT_PENDING);
                $this->reservationService->save($reservation);

                return $this->json([
                    'redirectUrl' => '/payment?rideId=' . $annonce->getId() . '&reservationId=' . $reservation->getId(),
                    'message' => 'Proceed to online payment to confirm your booking',
                ]);
            }
        }

        return $this->json(['message' => 'Booking process for this case is not fully implemented.']);
    }
}
