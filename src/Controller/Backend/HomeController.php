<?php

namespace App\Controller\Backend;

use App\Repository\UserRepository;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{

    private $current_url = 'home';


    /**
     * @Route("/admin", name="admin")
     * @param UserRepository $repoUser
     */
    public function index()
    {
        return $this->render('admin/home.html.twig', [
            'current_url' => $this->current_url,
        ]);
    }

}
