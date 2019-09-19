<?php

namespace App\Controller\Backend;

use App\Entity\RemorqueType;
use App\Repository\RemorqueTypeRepository;
use App\Form\RemorqueTypeType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class RemorqueTypeController extends AbstractController
{

    private $current_url = 'remorque';

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var RemorqueTypeRepository
     */
    private $repository;

    public function __construct(ObjectManager $em, RemorqueTypeRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/remorque/type", name="admin.remorque.type.index")
     * @param ObjectManager em
     * @param RemorqueTypeRepository repository
     * @param Request $request
     */
    public function index(Request $request)
    {
        $remorqueType = new RemorqueType();
        $form = $this->createForm(RemorqueTypeType::class, $remorqueType);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($remorqueType);
            $this->em->flush();
            $this->addFlash('success', 'Le type <strong>'.$remorqueType->getDenomination().'</strong> à été ajouté');
            return $this->redirectToRoute('admin.remorque.type.index');
        }

        $remorqueTypes = $this->repository->findAll();
        return $this->render('backend/remorque/type/index.html.twig', [
            'current_url' => $this->current_url,
            'remorqueTypes' => $remorqueTypes,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/remorque/type/delete.{id}", name="admin.remorque.type.delete", methods="DELETE")
     * @param ObjectManager em
     * @param RemorqueType $remorqueType
     */
    public function delete(RemorqueType $remorqueType)
    {
      $this->em->remove($remorqueType);
      $this->em->flush();
      $this->addFlash('success', 'Le type <strong>'.$remorqueType->getDenomination().'</strong> à été supprimé');
      return $this->redirectToRoute('admin.remorque.type.index');
    }


    /**
     * @Route("/admin/remorque/type/editer.{id}", name="admin.remorque.type.editer")
     * @param ObjectManager em
     * @param RemorqueType $remorqueType
     * @param Request $request
     */
    public function editer(Request $request, RemorqueType $remorqueType)
    {
        $form = $this->createForm(RemorqueTypeType::class, $remorqueType, [
            'action' => $this->generateUrl('admin.remorque.type.editer', ['id' => $remorqueType->getId()]),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Le type <strong>'.$remorqueType->getDenomination().'</strong> à été modifié');
            return $this->redirectToRoute('admin.remorque.type.index');
        }

        return $this->render('backend/remorque/type/_form.html.twig', [
            'remorqueTypes' => $remorqueType,
            'form' => $form->createView()
        ]);
    }

}
