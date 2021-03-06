<?php

namespace App\Controller\Frontend;

use App\Entity\Operation;
use App\Entity\Planning;
use App\Repository\PlanningRepository;
use App\Form\Frontend\OperationPlanningType;
use App\Repository\OperationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
* @Security("has_role('ROLE_EMPLOYE')")
*/
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
     * @param OperationRepository $repo
     */
    public function index(OperationRepository $repo)
    {
        $plannings = $this->repository->getPlanning();
        $opes = $repo->getDeleteOperationPlanning();
        $date = date("d-m-Y");
        foreach($opes as $ope)
        {
            if($ope->getDateCreation()->format('d-m-Y') != $date) {
                $this->em->remove($ope);
                $this->em->flush();
                return $this->redirectToRoute('planning');
            }

        }
        return $this->render('frontend/planning/index.html.twig', [
            'current_url' => $this->current_url,
            'plannings' => $plannings,
        ]);
    }


    /**
     * @Route("/planning/new.{id}", name="planning.new")
     * @param ObjectManager $this->em
     * @param Request $request
     * @param Planning $planning
     */
    public function newPlanning(Request $request, Planning $planning, OperationRepository $repository)
    {

        $operation = new Operation();
        $form = $this->createForm(OperationPlanningType::class, $operation, [
            'action' => $this->generateUrl('planning.new', ['id' => $planning->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $operationRe = $repository->getSearchRemorque($request->request->get('operation_planning')['remorque']);
            if($operationRe) {
                $operationRe->setParking(NULL);
                $operationRe->setTraction(NULL);
                $operationRe->setQuai(NULL);
                $operationRe->setOperation(2);
                $operationRe->setAffectation($request->request->get('operation_planning')['affectation']);
                $operationRe->setPlanning($planning);
            }
            else {
                $operation->setOperation(2);
                $operation->setPlanning($planning);
                $this->em->persist($operation);
            }
            $this->em->flush();
            $this->addFlash('success', 'La remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong> à été affectée a la tournée <strong>'.$planning->getTournee().'</strong>');
            return $this->redirectToRoute('planning');
        }

        return $this->render('frontend/planning/_form.html.twig', [
            'form' => $form->createView(),
            'planning' => $planning,

        ]);
    }


    /**
     * @Route("/planning/modifier.{id}", name="planning.editer")
     * @param ObjectManager $this->em
     * @param Operation $operation
     * @param Request $request
     */
    public function editerPlanning(Request $request, Operation $operation)
    {
        $form = $this->createForm(OperationPlanningType::class, $operation, [
            'action' => $this->generateUrl('planning.editer', ['id' => $operation->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $operation->setParking(NULL);
            $operation->setTraction(NULL);
            $operation->setQuai(NULL);
            $this->em->flush();
            //$this->addFlash('success', 'Le quai <strong>'.$operation->getQuai()->getNumero().'</strong> à été modifié, ajout de la remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong>');
            return $this->redirectToRoute('planning');
        }

        return $this->render('frontend/planning/_form.html.twig', [
            'form' => $form->createView(),
            'operation' => $operation
        ]);
    }
}
