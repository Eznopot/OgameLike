<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\ManagerServices;

class BuildProductionController extends AbstractController
{
    /** @var ManagerServices $ManagerServices */
    private $ManagerServices;

    public function __construct()
    {
        $this->ManagerServices = new ManagerServices();
    }
    
    #[Route('/build/production', name: 'build_production')]
    public function index(): Response
    {
        $this->ManagerServices->AllUpdater(
            $this->getDoctrine(),
            $this->getUser()
        );

        return $this->render('build_production/index.html.twig', [
            'user' => $this->getUser(),
            'buildingsOwned' => $this->getUser()->getBatimentsOwned()
        ]);
    }
}
