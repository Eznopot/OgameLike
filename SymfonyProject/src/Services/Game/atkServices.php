<?php

namespace App\Services;

use App\Entity\OngoingAtk;
use App\Entity\Planets;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class atkServices
{
    public function __construct()
    {
    }

    public function getAtkList(ManagerRegistry $doctrines) : array {
        $request = Request::createFromGlobals();
        return $doctrines->getRepository(OngoingAtk::class)->findAll();
    }

    public function getPlanetList(ManagerRegistry $doctrines) : array {
        $request = Request::createFromGlobals();
        return $doctrines->getRepository(Planets::class)->findAll();
    }
}
