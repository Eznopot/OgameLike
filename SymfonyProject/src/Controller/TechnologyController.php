<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class TechnologyController extends AbstractController
{
    #[Route('/technology', name: 'technology')]
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $request = Request::createFromGlobals();
        $upgradeId = $request->request->get('type');

        for ($i=0; $i < count($this->getUser()->getUserTechnoOwned()); $i++) {
            $dateNow = new \DateTime('now');
            $endUpgrade = $this->getUser()->getUserTechnoOwned()[$i]->getEndupgrade();

            if ($endUpgrade != null && $endUpgrade->format('Y-m-d h:i:s') < $dateNow->format('Y-m-d h:i:s')) {
                $this->getUser()->getUserTechnoOwned()[$i]->setUpgrading(False)
                    ->setEndupgrade(null)
                    ->setStartupgrade(null)
                    ->setLevel($this->getUser()->getUserTechnoOwned()[$i]->getLevel() + 1);
                $em->persist($this->getUser()->getUserTechnoOwned()[$i]);
                $em->flush();
            }
        }

        if ($upgradeId !== null) {
            for ($i=0; $i < count($this->getUser()->getUserTechnoOwned()); $i++) {
                if ($this->getUser()->getUserTechnoOwned()[$i]->getType()->getId() == $upgradeId) {
                    $upgradeTime = $this->getUser()->getUserTechnoOwned()[$i]->getType()->getUpgradeTime();
                    $endUpgrade = new \DateTime('now');
                    $endUpgrade->add(new \DateInterval('PT'.$upgradeTime.'S'));

                    $this->getUser()->getUserTechnoOwned()[$i]->setEndupgrade($endUpgrade)
                        ->setStartupgrade(new \DateTime('now'))
                        ->setUpgrading(True);
                    $em->persist($this->getUser()->getUserTechnoOwned()[$i]);
                    $em->flush();
                }
            }
        }


        return $this->render('technology/index.html.twig', [
            'user' => $this->getUser(),
            'technoOwned' => $this->getUser()->getUserTechnoOwned()
        ]);
    }
}
