<?php

namespace App\Controller\App;

use App\Repository\ParkingRepository;
use App\Form\OperationParkingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ParkingController extends AbstractController
{

    /**
     * @Route("parking", name="parking")
     */
    public function index(ParkingRepository $repository)
    {


        $parkings = $repository->getParkings();
        return $this->render('app/parking/index.html.twig', [
            'current_url' => 'parking',
            'parkings' => $parkings,
            //'form' => $form->createView()
        ]);
    }
}
