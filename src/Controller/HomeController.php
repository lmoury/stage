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
     */
    public function index(QuaiRepository $repoQuai)
    {
        $quais = $repoQuai->getQuais();
        return $this->render('home/index.html.twig', [
            'quais' => $quais,
        ]);
    }

}
