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

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }


    /**
     * @Route("parking", name="parking")
     */
    public function index(ParkingRepository $repository)
    {
        $parkings = $repository->getParkings();
        return $this->render('app/parking/index.html.twig', [
            'current_url' => 'parking',
            'parkings' => $parkings,
        ]);
    }

    /**
     * @Route("/parquer.{id}", name="parking.parquer")
     * @param Operation $operation
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
            $this->addFlash('success', 'La discussion a été supprimer avec success');
            return $this->redirectToRoute('parking');
        }

        return $this->render('app/quai/_form.html.twig', [
            'form' => $form->createView(),
            'operation' => $operation,

        ]);
    }
}
