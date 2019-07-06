<?php

namespace App\Controller\App;

use App\Entity\Operation;
use App\Repository\ParkingRepository;
use App\Form\OperationParkingType;
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
     * @Route("parking", name="parking")
     * @param ParkingRepository $repository
     */
    public function index()
    {
        $parkings = $this->repository->getParkings();
        return $this->render('app/parking/index.html.twig', [
            'current_url' => $this->current_url,
            'parkings' => $parkings,
        ]);
    }

    /**
     * @Route("/parquer.{id}", name="parking.parquer")
     * @param Operation $operation
     * @param Request $request
     */
    public function parquer(Request $request, Operation $operation)
    {

        $form = $this->createForm(OperationParkingType::class, $operation, [
            'action' => $this->generateUrl('parking.parquer', ['id' => $operation->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $operation->setOperation(4);
            $operation->setQuai(NULL);
            $operation->setDateCreation(new \DateTime());
            $this->em->flush();
            $this->addFlash('success', 'La remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong> à été mise sur le parking : <strong>'.$operation->getParking()->getDenomination().'</strong>');
            return $this->redirectToRoute('parking');
        }

        return $this->render('app/parking/_form.html.twig', [
            'form' => $form->createView(),
            'operation' => $operation,

        ]);
    }
}
