<?php

namespace App\Controller\Frontend;

use App\Entity\Operation;
use App\Repository\PlanningRepository;
use App\Form\OperationPlanningType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PlanningController extends AbstractController
{

    private $current_url = 'planning';

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var PlanningRepository
     */
    private $repository;

    public function __construct(ObjectManager $em, PlanningRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }


    /**
     * @Route("planning", name="planning")
     * @param PlanningRepository $repository
     */
    public function index(Request $request)
    {
        $plannings = $this->repository->findAll();
        return $this->render('frontend/planning/index.html.twig', [
            'current_url' => $this->current_url,
            'plannings' => $plannings,
        ]);
    }


    /**
     * @Route("/planning/affecter.{id}", name="planning.affecter", methods="GET|POST")
     * @param ObjectManager em
     * @param Operation $operation
     * @param Request $request
     */
    public function affecter(Request $request, Operation $operation)
    {
        $form = $this->createForm(OperationPlanningType::class, $operation, [
            'action' => $this->generateUrl('planning.affecter', ['id' => $operation->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $operation->setOperation(5);
            $operation->setDateCreation(new \DateTime());
            $this->em->flush();
            //$this->addFlash('success', 'La remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong> à été mise sur le parking : <strong>'.$operation->getParking()->getDenomination().'</strong>');
            return $this->redirectToRoute('planning');
        }

        return $this->render('frontend/planning/_form.html.twig', [
            'form' => $form->createView(),
            'operation' => $operation,
        ]);
    }

}
