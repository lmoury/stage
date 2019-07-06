<?php

namespace App\Controller\App;

use App\Repository\QuaiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var QuaiRepository
     */
    private $repository;

    public function __construct(QuaiRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="/")
     * @param QuaiRepository $repository
     */
    public function index()
    {
        $quais = $this->repository->getQuais();
        return $this->render('app/home/index.html.twig', [
            'quais' => $quais,
        ]);
    }

    /**
     * @Route("/plan", name="plan")
     * @param QuaiRepository $repository
     */
    public function plan(QuaiRepository $repoQuai)
    {
        $quais = $this->repository->getQuais();
        return $this->render('app/home/plan.html.twig', [
            'quais' => $quais,
        ]);
    }

}
