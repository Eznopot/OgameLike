<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\ManagerServices;
use App\Entity\Planets;

class SolarsystemController extends AbstractController
{
    /** @var ManagerServices $ManagerServices */
    private $ManagerServices;

    public function __construct()
    {
        $this->ManagerServices = new ManagerServices();
    }

    #[Route('/solarsystem', name: 'solarsystem')]
    public function index(): Response
    {
        $this->ManagerServices->AllUpdater(
            $this->getDoctrine(),
            $this->getUser()
        );

        return $this->render('solarsystem/index.html.twig', [
            'user' => $this->getUser(),
            "allPlanet" => $this->getDoctrine()->getRepository(Planets::class)->findAll()
        ]);
    }
}
