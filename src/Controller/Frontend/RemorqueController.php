<?php

namespace App\Controller\Frontend;

use App\Entity\Operation;
use App\Entity\Remorque;
use App\Repository\RemorqueRepository;
use App\Form\Frontend\Remorque\BloquerType;
use App\Form\Frontend\Remorque\EtatType;
use App\Form\Frontend\Remorque\EmplacementParkingType;
use App\Form\Frontend\Remorque\EmplacementQuaiType;
use App\Repository\OperationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
* @Security("has_role('ROLE_PARKING')")
*/
class RemorqueController extends AbstractController
{

    private $current_url = 'remorques';

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
     * @Route("/remorques", name="remorques")
     * @param RemorqueRepository $this->repository
     */
    public function index()
    {
        if($this->getUser()->getRole() == 3) {
            $remorques = $this->repository->getRemorquesParking();
        }
        else {
            $remorques = $this->repository->getRemorques();
        }

        return $this->render('frontend/remorque/index.html.twig', [
            'current_url' => $this->current_url,
            'remorques' => $remorques,
        ]);
    }


    /**
     * @Route("/remorques/bloquer.{id}", name="remorques.bloquer")
     * @param ObjectManager $this->em
     * @param Request $request
     * @param Remorque $remorque
     */
    public function bloquerRemorque(Request $request, Remorque $remorque)
    {

        $form = $this->createForm(BloquerType::class, $remorque, [
            'action' => $this->generateUrl('remorques.bloquer', ['id' => $remorque->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $remorque->setMaintenance(true);
            $this->em->flush();
            $this->addFlash('success', 'La remorque <strong>'.$remorque->getRemorque().'</strong> a étais bloquée </strong>');
            return $this->redirectToRoute('remorques');
        }

        return $this->render('frontend/remorque/form/bloquer.html.twig', [
            'form' => $form->createView(),
            'remorque' => $remorque,

        ]);
    }


    /**
     * @Route("/remorques/debloquer.{id}", name="remorques.debloquer", methods="GET|POST")
     * @param ObjectManager $this->em
     * @param Remorque $remorque
     */
    public function debloquerRemorque(Remorque $remorque)
    {
        $remorque->setMaintenance(false);
        $remorque->setMaintenanceRaison("");
        $this->em->flush();
        $this->addFlash('success', 'La remorque <strong>'.$remorque->getRemorque().'</strong> a étais bloquée </strong>');
        return $this->redirectToRoute('remorques');
    }


    /**
     * @Route("/remorques/etat.{id}", name="remorques.etat")
     * @param ObjectManager $this->em
     * @param Request $request
     * @param Remorque $remorque
     */
    public function etatRemorque(Request $request, Remorque $remorque)
    {

        $form = $this->createForm(EtatType::class, $remorque, [
            'action' => $this->generateUrl('remorques.etat', ['id' => $remorque->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('remorques');
        }

        return $this->render('frontend/remorque/form/etat.html.twig', [
            'form' => $form->createView(),
            'remorque' => $remorque,

        ]);
    }


    /**
     * @Route("/remorques/emplacement.{id}", name="remorques.emplacement")
     * @param ObjectManager $this->em
     * @param Request $request
     * @param Remorque $remorque
     */
    public function emplacementRemorque(Request $request, Remorque $remorque, OperationRepository $opRepository)
    {

        $operation = new Operation();
        $formParking = $this->createForm(EmplacementParkingType::class, $operation, [
            'action' => $this->generateUrl('remorques.emplacement', ['id' => $remorque->getId()]),
        ]);
        $formParking->handleRequest($request);

        if($formParking->isSubmitted() && $formParking->isValid()) {

            $operationRe = $opRepository->getSearchRemorque($remorque->getId());
            if($operationRe) {
                $operationRe->setQuai(NULL);
                $operationRe->setTraction(NULL);
                $operationRe->setPlanning(NULL);
                $operationRe->setParking($operation->getParking());
                $operationRe->setOperation(4);
            }
            else {
                $operation->setRemorque($remorque);
                $operation->setOperation(4);
                $this->em->persist($operation);
            }
            $this->em->flush();
            return $this->redirectToRoute('remorques');
        }

        return $this->render('frontend/remorque/form/emplacement.html.twig', [
            'form' => $formParking->createView(),
            'remorque' => $remorque,

        ]);
    }
}
