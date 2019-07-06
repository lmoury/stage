<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    private $current_url = 'home';

    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('backend/home/index.html.twig', [
            'current_url' => $this->current_url,
        ]);
    }

}
