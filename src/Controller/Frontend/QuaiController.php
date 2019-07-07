<?php

namespace App\Controller\Frontend;

use App\Entity\Quai;
use App\Entity\Operation;
use App\Repository\QuaiRepository;
use App\Repository\OperationRepository;
use App\Form\OperationQuaiType;
use App\Form\OperationParkingType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class QuaiController extends AbstractController
{

    private $current_url = 'quais';

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/quai", name="quai")
     * @param QuaiRepository $repoQuai
     */
    public function index(QuaiRepository $repoQuai)
    {
        $quais = $repoQuai->getQuais();
        return $this->render('frontend/quai/index.html.twig', [
            'current_url' => $this->current_url,
            'quais' => $quais,
        ]);
    }

    /**
     * @Route("/quai/deplacer.{id}", name="app.quai.deplacer", methods="GET|POST")
     * @param ObjectManager em
     * @param Operation $operation
     */
    public function terminer(Operation $operation)
    {
        $operation->setOperation(3);
        $this->em->flush();
        $this->addFlash('success', 'Opération terminé sur le quai <strong>'.$operation->getQuai()->getNumero().'</strong>, la remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong> peux etre deplacé');
        return $this->redirectToRoute('quai');
    }


    /**
     * @Route("/quai/new.{id}", name="quai.new")
     * @param Quai $quai
     */
    public function newQuai(Request $request, Quai $quai, OperationRepository $repository)
    {

        $operation = new Operation();
        $form = $this->createForm(OperationQuaiType::class, $operation, [
            'action' => $this->generateUrl('quai.new', ['id' => $quai->getId()]),
        ]);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $operationRe = $repository->getSearchRemorque($request->request->get('operation_quai')['remorque']);
            if($operationRe) {
                $operationRe->setParking(NULL);
                $operationRe->setOperation(2);
                $operationRe->setQuai($quai);
                $this->em->flush();
            }
            else {
                $operation->setOperation(2);
                $operation->setQuai($quai);
                $this->em->persist($operation);
                $this->em->flush();
            }

            $this->addFlash('success', 'La remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong> a étais mise sur le quai <strong>'.$quai->getNumero().'</strong>');
            return $this->redirectToRoute('quai');
        }

        return $this->render('frontend/quai/_form.html.twig', [
            'form' => $form->createView(),
            'quai' => $quai,

        ]);
    }

    /**
     * @Route("/quai/modifier.{id}", name="quai.modifier")
     * @param Operation $operation
     */
    public function editerQuai(Request $request, Operation $operation)
    {
        $form = $this->createForm(OperationQuaiType::class, $operation, [
            'action' => $this->generateUrl('quai.modifier', ['id' => $operation->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $operation->setDateCreation(new \DateTime());
            $this->em->flush();
            $this->addFlash('success', 'Le quai <strong>'.$operation->getQuai()->getNumero().'</strong> à été modifié, ajout de la remorque <strong>'.$operation->getRemorque()->getRemorque().'</strong>');
            return $this->redirectToRoute('quai');
        }

        return $this->render('frontend/quai/_form.html.twig', [
            'form' => $form->createView(),
            'operation' => $operation


        ]);
    }
}
