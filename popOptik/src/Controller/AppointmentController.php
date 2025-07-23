<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Appointment;
use App\Form\AppointmentType;
use App\Repository\AppointmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AppointmentController extends AbstractController
{
    // #[Route('/appointment', name: 'app_appointment')]
    // public function index(): Response
    // {
    //     return $this->render('appointment/index.html.twig', [
    //         'controller_name' => 'AppointmentController',
    //     ]);
    // }
    #[Route('/appointment/new', name: 'appointment_new')]
    public function new(Request $request, EntityManagerInterface $em, AppointmentRepository $appointmentRepo): Response
    {
        $appointment = new Appointment();
        $appointment->setUserRDV($this->getUser()); // Utilisateur connecté

        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = $appointment->getAppointmentDate();
            $hour = $appointment->getAppointmentHour();

            $existing = $appointmentRepo->findOneBy([
                'appointmentDate' => $date,
                'appointmentHour' => $hour,
            ]);

            if ($existing) {
                $this->addFlash('error', 'Ce créneau est déjà pris, merci d’en choisir un autre.');
            } else {
                $em->persist($appointment);
                $em->flush();

                $this->addFlash('success', 'Rendez-vous enregistré.');
                return $this->redirectToRoute('homepage');
            }
        }

        return $this->render('appointment/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/appointment/events', name: 'appointment_events', methods: ['GET'])]
    public function events(AppointmentRepository $repo): JsonResponse
    {
        $appointments = $repo->findAll();

        $events = [];
        foreach ($appointments as $appointment) {
            $date = $appointment->getAppointmentDate()->format('Y-m-d');
            $hour = $appointment->getAppointmentHour()->format('H:i:s');

            // Combinaison date + heure en ISO8601 pour FullCalendar
            $start = $date . 'T' . $hour;

            $events[] = [
                'title' => 'Réservé',
                'start' => $start,
                'allDay' => false,
                'color' => '#e74c3c',
                'textColor' => '#fff',
                'className' => 'rdv-reserve'
            ];
        }

        return new JsonResponse($events);
    }

    #[Route('/appointment/book/{date}/{hour}', name: 'appointment_book')]
    public function book(string $date, string $hour): Response
    {
        return $this->render('appointment/book.html.twig', [
            'date' => $date,
            'hour' => $hour,
        ]);
    }

    #[Route('/appointment/save', name: 'appointment_save', methods: ['POST'])]
    public function save(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour réserver un rendez-vous.');
            return $this->redirectToRoute('app_login');
        }

        $dateStr = $request->request->get('date'); // format YYYY-MM-DD
        $hourStr = $request->request->get('hour'); // format HH:mm

        $appointmentDate = \DateTime::createFromFormat('Y-m-d', $dateStr);
        $appointmentHour = \DateTime::createFromFormat('H:i', $hourStr);

        // Vérifier si déjà pris
        $already = $em->getRepository(Appointment::class)->findOneBy([
            'appointmentDate' => $appointmentDate,
            'appointmentHour' => $appointmentHour,
        ]);
        if ($already) {
            $this->addFlash('error', '❌ Ce créneau est déjà réservé !');
            return $this->redirectToRoute('appointment_new');
        }

        $appointment = new Appointment();
        $appointment->setAppointmentDate($appointmentDate);
        $appointment->setAppointmentHour($appointmentHour);
        $appointment->setUserAppointment($user);

        $em->persist($appointment);
        $em->flush();

        $this->addFlash('success', '✅ Rendez-vous confirmé avec succès.');
        return $this->redirectToRoute('app_user');
    }

    #[Route('/appointments/booked', name: 'appointments_booked', methods: ['GET'])]
    public function booked(AppointmentRepository $repo): JsonResponse
    {
        $appointments = $repo->findAll();

        $events = [];
        foreach ($appointments as $appointment) {
            $events[] = [
                'title' => 'Réservé',
                'start' => $appointment->getAppointmentDate()->format('Y-m-d'),
                'color' => '#ff0000'
            ];
        }

        return $this->json($events);
    }
    #[Route('/appointments/booked/{date}', name: 'appointments_booked_by_date', methods: ['GET'])]
    public function bookedByDate(string $date, AppointmentRepository $repo): JsonResponse
    {
        $dateObj = \DateTime::createFromFormat('Y-m-d', $date);
        if (!$dateObj) {
            return $this->json(['error' => 'Date invalide'], 400);
        }

        $appointments = $repo->findBy(['appointmentDate' => $dateObj]);

        $takenHours = array_map(function ($a) {
            return $a->getAppointmentHour()->format('H:i');
        }, $appointments);

        return $this->json($takenHours);
    }

    #[Route('/appointment/{id}/update-date', name: 'appointment_update_date', methods: ['POST'])]
    public function updateDate(
        int $id,
        Request $request,
        AppointmentRepository $repo,
        EntityManagerInterface $em
    ): JsonResponse {
        $appointment = $repo->find($id);

        if (!$appointment) {
            return $this->json(['error' => 'RDV introuvable'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $newDate = new \DateTime($data['date']);
        $newHour = \DateTime::createFromFormat('H:i', $data['hour']);

        // Vérifier si déjà pris
        $already = $repo->findOneBy([
            'appointmentDate' => $newDate,
            'appointmentHour' => $newHour
        ]);
        if ($already) {
            return $this->json(['error' => 'Créneau déjà réservé'], 400);
        }

        $appointment->setAppointmentDate($newDate);
        $appointment->setAppointmentHour($newHour);

        $em->flush();

        return $this->json(['success' => true]);
    }
}
