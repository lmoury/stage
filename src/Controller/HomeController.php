<?php

namespace App\Controller;

use App\Repository\QuaiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="/")
     * @param QuaiRepository $repoQuai
     */
    public function index(QuaiRepository $repoQuai)
    {
        $quais = $repoQuai->getQuais();
        return $this->render('home/index.html.twig', [
            'quais' => $quais,
        ]);
    }

    /**
     * @Route("/plan", name="plan")
     * @param QuaiRepository $repoQuai
     */
    public function plan(QuaiRepository $repoQuai)
    {
        $quais = $repoQuai->getQuais();
        return $this->render('home/plan.html.twig', [
            'quais' => $quais,
        ]);
    }

}
