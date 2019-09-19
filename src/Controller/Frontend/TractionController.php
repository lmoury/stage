<?php

namespace App\Controller\Frontend;

use App\Entity\Operation;
use App\Entity\Traction;
use App\Repository\TractionRepository;
use App\Repository\OperationRepository;
use App\Form\Frontend\OperationTractionType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
* @Security("has_role('ROLE_PARKING')")
*/
class TractionController extends AbstractController
{

    private $current_url = 'traction';

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
     * @Route("traction", name="traction")
     * @param TractionRepository $repository
     * @param OperationRepository $repo
     */
    public function index(OperationRepository $repo)
    {
        $tractions = $this->repository->findAll();
        $opes = $repo->getDeleteOperationTraction();
        $date = date("d-m-Y");
        foreach($opes as $ope)
        {
            if($ope->getDateCreation()->format('d-m-Y') != $date) {
                $this->em->remove($ope);
                $this->em->flush();
                return $this->redirectToRoute('traction');
            }

        }
        return $this->render('frontend/traction/index.html.twig', [
            'current_url' => $this->current_url,
            'tractions' => $tractions,
        ]);
    }


    /**
     * @Route("/traction/new.{id}", name="traction.new")
     * @param Request $request
     * @param Traction $traction
     */
    public function newTraction(Request $request, Traction $traction, OperationRepository $repository)
    {

        $operation = new Operation();
        $form = $this->createForm(OperationTractionType::class, $operation, [
            'action' => $this->generateUrl('traction.new', ['id' => $traction->getId()]),
        ]);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $operationRe = $repository->getSearchRemorque($request->request->get('operation_traction')['remorque']);
            if($operationRe) {
                $operationRe->setPlanning(NULL);
                $operationRe->setQuai(NULL);
                $operationRe->setOperation(2);
                $operationRe->setAffectation($traction->getAffectation());
                $operationRe->setTraction($traction);
                $operationRe->setDateCreation(new \DateTime());
            }
            else {
                $operation->setOperation(2);
                $operation->setAffectation($traction->getAffectation());
                $operation->setTraction($traction);
                $this->em->persist($operation);
            }
            $this->em->flush();
            $this->addFlash('success', 'La remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong> à été affectée sur le quai <strong>'.$traction->getQuai()->getNumero().'</strong>');
            return $this->redirectToRoute('traction');
        }

        return $this->render('frontend/traction/_form.html.twig', [
            'form' => $form->createView(),
            'traction' => $traction,

        ]);
    }


    /**
     * @Route("/traction/modifier.{id}", name="traction.editer")
     * @param Operation $operation
     * @param Request $request
     */
    public function editerTraction(Request $request, Operation $operation, OperationRepository $repository)
    {
        $form = $this->createForm(OperationTractionType::class, $operation, [
            'action' => $this->generateUrl('traction.editer', ['id' => $operation->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $operationRe = $repository->getSearchRemorque($request->request->get('operation_traction')['remorque']);
            if($operationRe) {
                $operationRe->setTraction($operation->getTraction());
                $this->em->flush();
            }
            $operation->setRemorque(getRemorque());
            $operation->setTraction(NULL);
            $this->em->flush();
            //$this->addFlash('success', 'Le quai <strong>'.$operation->getQuai()->getNumero().'</strong> à été modifié, ajout de la remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong>');
            return $this->redirectToRoute('traction');
        }

        return $this->render('frontend/traction/_form.html.twig', [
            'form' => $form->createView(),
            'operation' => $operation
        ]);
    }


    /**
     * @Route("/remorques/aquai.{id}", name="remorques.aquai", methods="GET|POST")
     * @param ObjectManager $this->em
     * @param Operation $operation
     */
    public function aQuai(Operation $operation)
    {
        $operation->setParking(NULL);
        $operation->setQuai($operation->getTraction()->getQuai());
        $this->em->flush();
        $this->addFlash('success', 'La remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong> à été mise à quai </strong>');
        return $this->redirectToRoute('traction');
    }
}
