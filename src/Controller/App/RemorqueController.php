<?php

namespace App\Controller\App;

use App\Repository\RemorqueRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class RemorqueController extends AbstractController
{

    private $current_url = 'remorques';

    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/remorques", name="remorques")
     * @param RemorqueRepository $repoRemorque
     */
    public function index(RemorqueRepository $repoRemorque)
    {
        $remorques = $repoRemorque->findAll();
        return $this->render('app/remorque/index.html.twig', [
            'current_url' => $this->current_url,
            'remorques' => $remorques,
        ]);
    }

}
