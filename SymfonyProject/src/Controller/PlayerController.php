<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class PlayerController extends AbstractController
{
    #[Route('/player', name: 'player')]
    public function index(): Response
    {
        if ($this->getUser())
          $image = base64_encode(stream_get_contents($this->getUser()->getImage()));
        else $image = null;
        
        return $this->render('player/index.html.twig', [
            'user' => $this->getUser(),
            'image' => $image
        ]);
    }
}
