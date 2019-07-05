<?php

namespace App\Controller\Admin;

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
    private $repoQuai;

    public function __construct(ObjectManager $em, QuaiRepository $repoQuai)
    {
        $this->em = $em;
        $this->repoQuai = $repoQuai;
    }

    /**
     * @Route("/admin/quai", name="admin.quai.index")
     * @param QuaiRepository $repoQuai
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
            return $this->redirectToRoute('admin.quai.index');
        }

        $quais = $this->repoQuai->getQuais();
        return $this->render('admin/quai/index.html.twig', [
            'current_url' => $this->current_url,
            'quais' => $quais,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/commmentaire/{id}", name="admin.quai.delete", methods="DELETE")
     * @param ObjectManager em
     * @param Quai $quai
     * @param Request $request
     */
    public function delete(Quai $quai, Request $request)
    {
      $this->em->remove($quai);
      $this->em->flush();
      $this->addFlash('success', 'Quai supprimer avec success');
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
