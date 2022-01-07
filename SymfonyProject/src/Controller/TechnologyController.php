<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\TechnologiesOwned;

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

            if ($this->getUser()->getUserTechnoOwned()[$i]->getEndupgrade() < $dateNow) {
                $this->getUser()->getUserTechnoOwned()[$i]->setUpgrading(False)
                                                        ->setEndupgrade(new \DateTime('now'))
                                                        ->setStartupgrade(new \DateTime('now'));

                $em->persist($this->getUser()->getUserTechnoOwned()[$i]);
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
                }
            }
        }

        $em->flush();

        return $this->render('technology/index.html.twig', [
            'technoOwned' => $this->getUser()->getUserTechnoOwned()
        ]);
    }
}
