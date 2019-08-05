<?php

namespace App\Controller\Frontend;

use App\Entity\Operation;
use App\Entity\Traction;
use App\Repository\TractionRepository;
use App\Repository\OperationRepository;
use App\Form\OperationParkingType;
use App\Form\OperationQuaiType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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
     */
    public function index(Request $request)
    {
        $tractions = $this->repository->findAll();
        return $this->render('frontend/traction/index.html.twig', [
            'current_url' => $this->current_url,
            'tractions' => $tractions,
        ]);
    }


    /**
     * @Route("/traction/deplacer.{id}", name="traction.terminer", methods="GET|POST")
     * @param ObjectManager em
     * @param Operation $operation
     */
    public function terminer(Operation $operation)
    {
        $operation->setOperation(3);
        $this->em->flush();
        $this->addFlash('success', 'Opération terminé, la remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong> peux etre deplacé');
        return $this->redirectToRoute('traction');
    }


    /**
     * @Route("/traction/new.{id}", name="traction.new")
     * @param Request $request
     * @param Traction $traction
     */
    public function newTraction(Request $request, Traction $traction, OperationRepository $repository)
    {

        $operation = new Operation();
        $form = $this->createForm(OperationQuaiType::class, $operation, [
            'action' => $this->generateUrl('traction.new', ['id' => $traction->getId()]),
        ]);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $operationRe = $repository->getSearchRemorque($request->request->get('operation_quai')['remorque']);
            if($operationRe) {
                $operationRe->setParking(NULL);
                $operationRe->setOperation(2);
                $operationRe->setTraction($traction);
            }
            else {
                $operation->setOperation(2);
                $operation->setTraction($traction);
                $this->em->persist($operation);
            }
            $this->em->flush();
            $this->addFlash('success', 'La remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong> a étais affecté sur le quai <strong>'.$traction->getPorte().'</strong>');
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
    public function editerTraction(Request $request, Operation $operation)
    {
        $form = $this->createForm(OperationQuaiType::class, $operation, [
            'action' => $this->generateUrl('traction.editer', ['id' => $operation->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            //$this->addFlash('success', 'Le quai <strong>'.$operation->getQuai()->getNumero().'</strong> à été modifié, ajout de la remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong>');
            return $this->redirectToRoute('traction');
        }

        return $this->render('frontend/traction/_form.html.twig', [
            'form' => $form->createView(),
            'operation' => $operation
        ]);
    }
}