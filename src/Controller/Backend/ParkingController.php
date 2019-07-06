<?php

namespace App\Controller\Backend;

use App\Entity\Parking;
use App\Repository\ParkingRepository;
use App\Form\ParkingType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ParkingController extends AbstractController
{

    private $current_url = 'parking';

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var ParkingRepository
     */
    private $repoParking;

    public function __construct(ObjectManager $em, ParkingRepository $repoParking)
    {
        $this->em = $em;
        $this->repoParking = $repoParking;
    }

    /**
     * @Route("/admin/parking", name="admin.parking.index")
     * @param ParkingRepository $repoParking
     * @param Request $request
     */
    public function index(Request $request)
    {
        $parking = new Parking();
        $form = $this->createForm(ParkingType::class, $parking);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($parking);
            $this->em->flush();
            return $this->redirectToRoute('admin.parking.index');
        }

        $parkings = $this->repoParking->getParkings();
        return $this->render('backend/parking/index.html.twig', [
            'current_url' => $this->current_url,
            'parkings' => $parkings,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/parking/delete.{id}", name="admin.parking.delete", methods="DELETE")
     * @param ObjectManager em
     * @param Parking $parking
     * @param Request $request
     */
    public function delete(Parking $parking, Request $request)
    {
      $this->em->remove($parking);
      $this->em->flush();
      $this->addFlash('success', 'Parking supprimer avec success');
      return $this->redirectToRoute('admin.parking.index');
    }


    /**
     * @Route("/admin/parking/editer.{id}", name="admin.parking.editer")
     * @param Parking $parking
     * @param Request $request
     */
    public function editerParking(Request $request, Parking $parking)
    {
        $form = $this->createForm(ParkingType::class, $parking, [
            'action' => $this->generateUrl('admin.parking.editer', ['id' => $parking->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'La discussion a été supprimer avec success');
            return $this->redirectToRoute('admin.parking.index');
        }

        return $this->render('backend/parking/_form.html.twig', [
            'form' => $form->createView(),
            'parking' => $parking
        ]);
    }
}
