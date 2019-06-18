<?php

namespace App\Controller\Admin;

use App\Repository\RemorqueRepository;
use App\Entity\Remorque;
use App\Form\RemorqueType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class RemorqueController extends AbstractController
{

    private $current_url = 'remorque';

    /**
     * @var RemorqueRepository
     */
    private $repoRemorque;


    public function __construct(ObjectManager $em, RemorqueRepository $repoRemorque)
    {
            $this->em = $em;
            $this->repoRemorque = $repoRemorque;
    }


    /**
     * @Route("/admin/remorque", name="admin.remorque.index")
     * @param RemorqueRepository $repoRemorque
     */
    public function index()
    {
        $remorques = $this->repoRemorque->findAll();
        return $this->render('admin/remorque/index.html.twig', [
            'current_url' => $this->current_url,
            'remorques' => $remorques,
        ]);
    }


    /**
   * @Route("/admin/remorque/new", name="admin.remorque.new")
   * @param RemorqueRepository $repoRemorque
   * @param Request $request
   */
   public function new(Request $request)
   {

       $remorque = new Remorque();
       $form = $this->createForm(RemorqueType::class, $remorque);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()) {
           $this->em->persist($remorque);
           $this->em->flush();
           return $this->redirectToRoute('admin.remorque.index');
       }

       return $this->render('admin/remorque/new.html.twig', [
           'current_url' => $this->current_url,
           'form' => $form->createView()
       ]);
   }


   /**
    * @Route("/admin/remorque/editer.{id}", name="admin.remorque.editer", methods="GET|POST")
    * @param Remorque $remorque
    * @param Request $request
    */
    public function editer(Remorque $remorque, Request $request)
    {

        $form = $this->createForm(RemorqueType::class, $remorque);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $remorque->setDateEdition(new \DateTime());
            $this->em->flush();
            return $this->redirectToRoute('admin.remorque.index');
        }

        return $this->render('admin/remorque/editer.html.twig', [
            'current_url' => $this->current_url,
            'form' => $form->createView(),
            'remorque' => $remorque
        ]);
    }

    /**
    * @Route("/admin/remorque/delete.{id}", name="admin.remorque.delete", methods="DELETE")
    * @param Remorque $remorque
    * @param Request $request
    */
    public function delete(Remorque $remorque, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $remorque->getId(), $request->get('_token'))) {
            $this->em->remove($remorque);
            $this->em->flush();
            $this->addFlash('success', 'La remorque a été supprimer avec success');
        }
        return $this->redirectToRoute('admin.remorque.index');
    }

}
