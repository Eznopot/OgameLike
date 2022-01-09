<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class LadderController extends AbstractController
{
    

    #[Route('/ladder', name: 'ladder')]
    public function index(): Response
    {
        $players = $this->getDoctrine()->getRepository(User::class)->findAll();
        
        usort($players, function ($a, $b) {
          return $a->getElo() < $b->getElo();
        });
        
        return $this->render('ladder/index.html.twig', [
            'user' => $this->getUser(),
            'players' => $players
        ]);
    }
}
