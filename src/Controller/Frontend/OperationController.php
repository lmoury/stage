<?php

namespace App\Controller\Frontend;

use App\Entity\Operation;
use App\Repository\TractionRepository;
use App\Repository\OperationRepository;
use App\Form\OperationParkingType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class OperationController extends AbstractController
{

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var TractionRepository
     */
    private $repository;

    public function __construct(ObjectManager $em, TractionRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }


    /**
     * @Route("/operation/tournee.{id}", name="operation.tournee", methods="GET|POST")
     * @param ObjectManager em
     * @param Operation $operation
     */
    public function tournee(Operation $operation)
    {
        $operation->setOperation(5);
        $operation->setTraction(null);
        $operation->setPlanning(null);
        $this->em->flush();
        $this->addFlash('success', 'Opération terminé, la remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong> peux partir en tournée');
        return $this->redirectToRoute('traction');
    }


    /**
     * @Route("/operation/peuxetreparque.{id}", name="operation.parque", methods="GET|POST")
     * @param ObjectManager em
     * @param Operation $operation
     */
    public function peuxEtreParque(Operation $operation)
    {
        $operation->setOperation(3);
        $this->em->flush();
        $this->addFlash('success', 'Opération terminé, la remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong> peux etre parqué');
        return $this->redirectToRoute('traction');
    }


    /**
     * @Route("operation/parquer.{id}", name="operation.parquer")
     * @param Operation $operation
     * @param Request $request
     */
    public function parquer(Request $request, Operation $operation)
    {

        $form = $this->createForm(OperationParkingType::class, $operation, [
            'action' => $this->generateUrl('operation.parquer', ['id' => $operation->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $operation->setOperation(4);
            $operation->setTraction(NULL);
            $operation->setPlanning(NULL);
            $operation->setDateCreation(new \DateTime());
            $this->em->flush();
            $this->addFlash('success', 'La remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong> à été mise sur le parking : <strong>'.$operation->getParking()->getDenomination().'</strong>');
            return $this->redirectToRoute('parking');
        }

        return $this->render('frontend/parking/_form.html.twig', [
            'form' => $form->createView(),
            'operation' => $operation,
        ]);
    }

}
