<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Technologies;

class TechnologiesController extends AbstractController
{
    #[Route('/technologies/ajax', name: 'technologies_ajax')]
    public function ajax(Request $request) {
        dump($request);
    }

    #[Route('/technologies', name: 'technologies')]
    public function index(): Response
    {

        $request = Request::createFromGlobals();
        $upgradeId = $request->request->get('type');

        if ($upgradeId !== null) {
            dump($upgradeId);
        }

        $technologies = $this->getDoctrine()->getRepository(Technologies::class)->findAll();


        return $this->render('technologies/index.html.twig', [
            'technolgiesStats' => $technologies
        ]);
    }
}
