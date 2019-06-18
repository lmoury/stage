<?php

namespace App\Controller\App;

use App\Entity\Quai;
use App\Entity\Operation;
use App\Repository\QuaiRepository;
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
     * @Route("/quai/editer.{id}", name="app.quai.edit", methods="GET|POST")
     * @param QuaiRepository $repoQuai
     */
    public function index(Request $request, Operation $operationQuai = null, QuaiRepository $repoQuai)
    {
        if(!$operationQuai) {
            $operationQuai = new Operation();
            $this->em->persist($operationQuai);
        }

        $form = $this->createForm(OperationQuaiType::class, $operationQuai);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $operationQuai->setOperation(2);
            $this->em->flush();
            $this->addFlash('success', 'La discussion a été supprimer avec success');
            return $this->redirectToRoute('quai');
        }

        $quais = $repoQuai->getQuais();
        return $this->render('app/quai/index.html.twig', [
            'current_url' => $this->current_url,
            'quais' => $quais,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/quai/deplacer.{id}", name="app.quai.deplacer", methods="GET|POST")
     * @param ObjectManager em
     * @param Operation $operation
     */
    public function deplacer(Operation $operation)
    {
        $operation->setOperation(3);
        $this->em->flush();
        return $this->redirectToRoute('quai');
    }


    /**
     * @Route("/quai/maintenance.{id}", name="app.quai.maintenance", methods="GET|POST")
     * @param ObjectManager em
     * @param Quai $quai
     */
    public function maintenance(Quai $quai)
    {
        if($quai->getMaintenance()) {
            $quai->setMaintenance(false);
        }
        else {
            $quai->setMaintenance(true);
        }
        $this->em->flush();
        return $this->redirectToRoute('quai');
    }

    /**
     * @Route("/quai/create.{id}", name="quai.create")
     * @param Operation $operation
     */
    public function create(Request $request, Operation $operation)
    {

        //$newOpe = $operation;
        $form = $this->createForm(OperationParkingType::class, $operation, [
            'action' => $this->generateUrl('quai.create', ['id' => $operation->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $operation->setOperation(4);
            $operation->setQuai(NULL);
            $operation->setDateCreation(new \DateTime());
            $this->em->flush();
            $this->addFlash('success', 'La discussion a été supprimer avec success');
            return $this->redirectToRoute('quai');
        }

        return $this->render('app/quai/_form.html.twig', [
            'form' => $form->createView(),
            'operation' => $operation,

        ]);
    }
}
