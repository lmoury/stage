<?php

namespace App\Controller\Backend;

use App\Entity\Quai;
use App\Repository\QuaiRepository;
use App\Form\QuaiType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class QuaiController extends AbstractController
{

    private $current_url = 'quai';

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var QuaiRepository
     */
    private $repository;

    public function __construct(ObjectManager $em, QuaiRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/quai", name="admin.quai.index")
     * @param QuaiRepository $repository
     * @param Request $request
     */
    public function index(Request $request)
    {
        $quai = new Quai();
        $form = $this->createForm(QuaiType::class, $quai);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($quai);
            $this->em->flush();
            $this->addFlash('success', 'Le quai <strong>'.$quai->getNumero().'</strong> à été ajouté');
            return $this->redirectToRoute('admin.quai.index');
        }

        $quais = $this->repository->getQuais();
        return $this->render('backend/quai/index.html.twig', [
            'current_url' => $this->current_url,
            'quais' => $quais,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/quai/delete.{id}", name="admin.quai.delete", methods="DELETE")
     * @param ObjectManager em
     * @param Quai $quai
     */
    public function delete(Quai $quai)
    {
      $this->em->remove($quai);
      $this->em->flush();
      $this->addFlash('success', 'Le quai <strong>'.$quai->getNumero().'</strong> à été supprimé');
      return $this->redirectToRoute('admin.quai.index');
    }



    /**
     * @Route("/admin/quai/maintenance.{id}", name="admin.quai.maintenance")
     * @param ObjectManager em
     * @param Quai $quai
     */
    public function maintenance(Quai $quai)
    {
        $action = ($quai->getMaintenance()) ? false : true;
        $quai->setMaintenance($action);
        $this->em->flush();
        return $this->redirectToRoute('admin.quai.index');
    }
}
