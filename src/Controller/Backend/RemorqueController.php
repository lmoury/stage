<?php

namespace App\Controller\Backend;

use App\Repository\RemorqueRepository;
use App\Entity\Remorque;
use App\Form\RemorquesType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class RemorqueController extends AbstractController
{

    private $current_url = 'remorque';

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
     * @Route("/admin/remorque", name="admin.remorque.index")
     * @param RemorqueRepository $repository
     */
    public function index()
    {
        $remorques = $this->repository->getRemorques();
        return $this->render('backend/remorque/index.html.twig', [
            'current_url' => $this->current_url,
            'remorques' => $remorques,
        ]);
    }


    /**
   * @Route("/admin/remorque/new", name="admin.remorque.new")
   * @param ObjectManager em
   * @param Request $request
   */
   public function new(Request $request)
   {

       $remorque = new Remorque();
       $form = $this->createForm(RemorquesType::class, $remorque);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()) {
           $this->em->persist($remorque);
           $this->em->flush();
           $this->addFlash('success', 'La remorque <strong>'.$remorque->getRemorque().'</strong> à été ajoutée');
           return $this->redirectToRoute('admin.remorque.index');
       }

       return $this->render('backend/remorque/new.html.twig', [
           'current_url' => $this->current_url,
           'form' => $form->createView()
       ]);
   }


   /**
    * @Route("/admin/remorque/editer.{id}", name="admin.remorque.editer", methods="GET|POST")
    * @param ObjectManager em
    * @param Remorque $remorque
    * @param Request $request
    */
    public function editer(Remorque $remorque, Request $request)
    {

        $form = $this->createForm(RemorquesType::class, $remorque);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $remorque->setDateEdition(new \DateTime());
            $this->em->flush();
            $this->addFlash('success', 'La remorque <strong>'.$remorque->getRemorque().'</strong> à été modifiée');
            return $this->redirectToRoute('admin.remorque.index');
        }

        return $this->render('backend/remorque/editer.html.twig', [
            'current_url' => $this->current_url,
            'form' => $form->createView(),
            'remorque' => $remorque
        ]);
    }

    /**
    * @Route("/admin/remorque/delete.{id}", name="admin.remorque.delete", methods="DELETE")
    * @param ObjectManager em
    * @param Remorque $remorque
    * @param Request $request
    */
    public function delete(Remorque $remorque, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $remorque->getId(), $request->get('_token'))) {
            $this->em->remove($remorque);
            $this->em->flush();
            $this->addFlash('success', 'La remorque <strong>'.$remorque->getRemorque().'</strong> à été supprimée');
        }
        return $this->redirectToRoute('admin.remorque.index');
    }

}
