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
        $id = 1;
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if ($user)
          $image = base64_encode(stream_get_contents($user->getImage()));
        else $image = null;
        
        return $this->render('player/index.html.twig', [
            'player' => $user,
            'image' => $image
        ]);
    }
}
