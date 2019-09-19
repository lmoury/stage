<?php

namespace App\Controller\Frontend;

use App\Repository\ParkingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
* @Security("has_role('ROLE_PARKING')")
*/
class ParkingController extends AbstractController
{

    private $current_url = 'parking';

    /**
     * @var ParkingRepository
     */
    private $repository;

    public function __construct(ParkingRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * @Route("parking", name="parking")
     * @param ParkingRepository $this->repository
     */
    public function index()
    {
        $parkings = $this->repository->getParkings();
        return $this->render('frontend/parking/index.html.twig', [
            'current_url' => $this->current_url,
            'parkings' => $parkings,
        ]);
    }
}
