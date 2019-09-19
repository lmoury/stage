<?php

namespace App\Controller\Backend;

use App\Entity\Traction;
use App\Repository\TractionRepository;
use App\Form\Backend\TractionType;
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
     * @Route("/admin/traction", name="admin.traction.index")
     * @param TractionRepository $this->repository
     */
    public function index()
    {
        $tractions = $this->repository->findAll();
        return $this->render('backend/traction/index.html.twig', [
            'current_url' => $this->current_url,
            'tractions' => $tractions,
        ]);
    }


    /**
   * @Route("/admin/traction/new", name="admin.traction.new")
   * @param ObjectManager $this->em
   * @param Request $request
   */
   public function new(Request $request)
   {

       $traction = new Traction();
       $form = $this->createForm(TractionType::class, $traction);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()) {
           $this->em->persist($traction);
           $this->em->flush();
           $this->addFlash('success', 'L\'affectation <strong>'.$traction->getAffectation().'</strong> à été ajoutée');
           return $this->redirectToRoute('admin.traction.index');
       }

       return $this->render('backend/traction/new.html.twig', [
           'current_url' => $this->current_url,
           'form' => $form->createView()
       ]);
   }


   /**
    * @Route("/admin/traction/editer.{id}", name="admin.traction.editer", methods="GET|POST")
    * @param ObjectManager $this->em
    * @param Traction $traction
    * @param Request $request
    */
    public function editer(Traction $traction, Request $request)
    {

        $form = $this->createForm(TractionType::class, $traction);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'L\'affectation <strong>'.$traction->getAffectation().'</strong> à été modifiée');
            return $this->redirectToRoute('admin.traction.index');
        }

        return $this->render('backend/traction/editer.html.twig', [
            'current_url' => $this->current_url,
            'form' => $form->createView(),
            'traction' => $traction
        ]);
    }

    /**
    * @Route("/admin/traction/delete.{id}", name="admin.traction.delete", methods="DELETE")
    * @param ObjectManager $this->em
    * @param Traction $traction
    * @param Request $request
    */
    public function delete(Traction $traction, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $traction->getId(), $request->get('_token'))) {
            $this->em->remove($traction);
            $this->em->flush();
            $this->addFlash('success', 'L\'affectation <strong>'.$traction->getAffectation().'</strong> à été supprimée');
        }
        return $this->redirectToRoute('admin.traction.index');
    }

}
