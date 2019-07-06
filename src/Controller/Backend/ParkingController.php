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
    private $repository;

    public function __construct(ObjectManager $em, ParkingRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/parking", name="admin.parking.index")
     * @param ObjectManager em
     * @param ParkingRepository $repository
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
            $this->addFlash('success', 'Le parking <strong>'.$parking->getDenomination().'</strong> à été ajouté');
            return $this->redirectToRoute('admin.parking.index');
        }

        $parkings = $this->repository->getParkings();
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
     */
    public function delete(Parking $parking)
    {
      $this->em->remove($parking);
      $this->em->flush();
      $this->addFlash('success', 'Le parking <strong>'.$parking->getDenomination().'</strong> à été supprimé');
      return $this->redirectToRoute('admin.parking.index');
    }


    /**
     * @Route("/admin/parking/editer.{id}", name="admin.parking.editer")
     * @param ObjectManager em
     * @param Parking $parking
     * @param Request $request
     */
    public function editer(Request $request, Parking $parking)
    {
        $form = $this->createForm(ParkingType::class, $parking, [
            'action' => $this->generateUrl('admin.parking.editer', ['id' => $parking->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Le parking <strong>'.$parking->getDenomination().'</strong> à été modifié');
            return $this->redirectToRoute('admin.parking.index');
        }

        return $this->render('backend/parking/_form.html.twig', [
            'form' => $form->createView(),
            'parking' => $parking
        ]);
    }
}
