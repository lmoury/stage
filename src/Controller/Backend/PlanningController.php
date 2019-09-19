<?php

namespace App\Controller\Backend;

use App\Entity\Planning;
use App\Repository\PlanningRepository;
use App\Form\Backend\PlanningType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class PlanningController extends AbstractController
{

    private $current_url = 'planning';

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var PlanningRepository
     */
    private $repository;


    public function __construct(ObjectManager $em, PlanningRepository $repository)
    {
            $this->em = $em;
            $this->repository = $repository;
    }


    /**
     * @Route("/admin/planning", name="admin.planning.index")
     * @param PlanningRepository $this->repository
     */
    public function index()
    {
        $planning = $this->repository->findAll();
        return $this->render('backend/planning/index.html.twig', [
            'current_url' => $this->current_url,
            'planning' => $planning,
        ]);
    }


    /**
   * @Route("/admin/planning/new", name="admin.planning.new")
   * @param ObjectManager $this->em
   * @param Request $request
   */
   public function new(Request $request)
   {

       $planning = new Planning();
       $form = $this->createForm(PlanningType::class, $planning);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()) {
           $this->em->persist($planning);
           $this->em->flush();
           $this->addFlash('success', 'La tournée <strong>'.$planning->getTournee().'</strong> à été ajoutée');
           return $this->redirectToRoute('admin.planning.index');
       }

       return $this->render('backend/planning/new.html.twig', [
           'current_url' => $this->current_url,
           'form' => $form->createView()
       ]);
   }


   /**
    * @Route("/admin/planning/editer.{id}", name="admin.planning.editer", methods="GET|POST")
    * @param ObjectManager $this->em
    * @param Planning $planning
    * @param Request $request
    */
    public function editer(Planning $planning, Request $request)
    {

        $form = $this->createForm(PlanningType::class, $planning);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'La tournée <strong>'.$planning->getTournee().'</strong> à été modifiée');
            return $this->redirectToRoute('admin.planning.index');
        }

        return $this->render('backend/planning/editer.html.twig', [
            'current_url' => $this->current_url,
            'form' => $form->createView(),
            'planning' => $planning
        ]);
    }

    /**
    * @Route("/admin/planning/delete.{id}", name="admin.planning.delete", methods="DELETE")
    * @param ObjectManager $this->em
    * @param Planning $planning
    * @param Request $request
    */
    public function delete(Planning $planning, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $planning->getId(), $request->get('_token'))) {
            $this->em->remove($planning);
            $this->em->flush();
            $this->addFlash('success', 'La tournée <strong>'.$planning->getTournee().'</strong> à été supprimée');
        }
        return $this->redirectToRoute('admin.planning.index');
    }

}
