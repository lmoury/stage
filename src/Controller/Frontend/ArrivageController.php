<?php

namespace App\Controller\Frontend;

use App\Entity\Operation;
use App\Entity\Remorque;
use App\Repository\RemorqueRepository;
use App\Repository\OperationRepository;
use App\Form\OperationParkingType;
use App\Form\Frontend\Remorque\EtatType;
use App\Form\Frontend\ArrivageType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
* @Security("has_role('ROLE_QUAI')")
*/
class ArrivageController extends AbstractController
{

    private $current_url = 'arrivages';

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var RemorqueRepository
     */
    private $repository;

    public function __construct(ObjectManager $em, RemorqueRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }


    /**
     * @Route("/arrivages", name="arrivages", methods="GET|POST")
     * @param RemorqueRepository $this->repository
     */
     public function index(Request $request, OperationRepository $repository)
     {
         $operation = new Operation();
         $form = $this->createForm(ArrivageType::class, $operation);
         $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()) {
             $operationRe = $repository->getSearchRemorque($request->request->get('arrivage')['remorque']);
             if($operationRe) {
                 $operationRe->setParking(NULL);
                 $operationRe->setTraction(NULL);
                 $operationRe->setPlanning(NULL);
                 $operationRe->getRemorque()->setVide(false);
                 $operationRe->setOperation(2);
                 $operationRe->setQuai($operation->getQuai());
             }
             else {
                 $operation->getRemorque()->setVide(false);
                 $operation->setOperation(2);
                 $this->em->persist($operation);
             }
             $this->em->flush();
             //$this->addFlash('success', 'Le quai <strong>'.$operation->getQuai()->getNumero().'</strong> à été modifié, ajout de la remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong>');
             return $this->redirectToRoute('arrivages');
         }
         $arrivages = $this->repository->getArrivages();

         return $this->render('frontend/arrivage/index.html.twig', [
             'form' => $form->createView(),
             'current_url' => $this->current_url,
             'arrivages' => $arrivages,
         ]);
     }


     /**
      * @Route("/arrivages/etat.{id}", name="arrivages.etat")
      * @param ObjectManager $this->em
      * @param Request $request
      * @param Remorque $remorque
      */
     public function etatRemorque(Request $request, Remorque $remorque)
     {

         $form = $this->createForm(EtatType::class, $remorque, [
             'action' => $this->generateUrl('arrivages.etat', ['id' => $remorque->getId()]),
         ]);
         $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()) {
             $this->em->flush();
             return $this->redirectToRoute('arrivages');
         }

         return $this->render('frontend/remorque/form/etat.html.twig', [
             'form' => $form->createView(),
             'remorque' => $remorque,

         ]);
     }
}
