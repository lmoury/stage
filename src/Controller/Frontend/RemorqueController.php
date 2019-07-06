<?php

namespace App\Controller\Frontend;

use App\Repository\RemorqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RemorqueController extends AbstractController
{

    private $current_url = 'remorques';

    /**
     * @var RemorqueRepository
     */
    private $repository;

    public function __construct(RemorqueRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/remorques", name="remorques")
     * @param RemorqueRepository $repository
     */
    public function index(RemorqueRepository $repository)
    {
        $remorques = $this->repository->getRemorques();
        return $this->render('frontend/remorque/index.html.twig', [
            'current_url' => $this->current_url,
            'remorques' => $remorques,
        ]);
    }

}
