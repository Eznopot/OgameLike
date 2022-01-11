<?php

namespace App\Services;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

class ManagerServices
{
    public function AllUpdater(ManagerRegistry $doctrine, User $user)
    {
        $this->TechnologyUpdater($doctrine, $user);
        $this->BuildBuyUpdater($doctrine, $user);
        $this->AttackUpdater($doctrine, $user);
        $this->GoldUnitsUpdater($doctrine, $user);
    }

    public function TechnologyUpdater(ManagerRegistry $doctrine, User $user)
    {
        $em = $doctrine->getManager();

        for ($i=0; $i < count($user->getUserTechnoOwned()); $i++) {
            $dateNow = new \DateTime('now');
            $endUpgrade = $user->getUserTechnoOwned()[$i]->getEndupgrade();

            if ($endUpgrade != null && $endUpgrade->format('Y-m-d h:i:s') < $dateNow->format('Y-m-d h:i:s')) {
                $user->getUserTechnoOwned()[$i]->setUpgrading(False)
                    ->setEndupgrade(null)
                    ->setStartupgrade(null)
                    ->setLevel($user->getUserTechnoOwned()[$i]->getLevel() + 1);
                $em->persist($user->getUserTechnoOwned()[$i]);
                $em->flush();
            }
        }
    }

    public function BuildBuyUpdater(ManagerRegistry $doctrine, User $user)
    {
        $em = $doctrine->getManager();

        for ($i=0; $i < count($user->getBatimentsOwned()); $i++) {
            $dateNow = new \DateTime('now');
            $buildOwned = $user->getBatimentsOwned()[$i];
            $endUpgrade = $buildOwned->getEndupgrade();

            if ($endUpgrade != null && $endUpgrade->format('Y-m-d h:i:s') < $dateNow->format('Y-m-d h:i:s')) {

                if ($buildOwned->getUpgradingType() == 'Upgrading') {
                    $buildOwned->setLevel($buildOwned->getLevel() + 1);
                }

                $buildOwned->setUpgrading(False)
                    ->setEndupgrade(null)
                    ->setStartupgrade(null)
                    ->setUpgradingType(null);

                $em->persist($buildOwned);
                $em->flush();
            }
        }
    }

    public function AttackUpdater(ManagerRegistry $doctrine, User $user)
    {
        $em = $doctrine->getManager();
        $allOnGoingAtk = $user->getOngoingAtks();

        for ($i=0; $i < $allOnGoingAtk->count(); $i++) {
            $dateNow = new \DateTime('now');
            $endOnGoingAtk = $allOnGoingAtk[$i]->getEndTime();

            if (!$allOnGoingAtk[$i]->getIdEnded() && $endOnGoingAtk->format('Y-m-d h:i:s') < $dateNow->format('Y-m-d h:i:s')) {
                $uniteAtk = 0;
                if ($allOnGoingAtk[$i]->getSuccessRate() > $allOnGoingAtk[$i]->getUnitsAtk()) {
                    $uniteAtk = $allOnGoingAtk[$i]->getUnitsAtk() * rand(0, 100) / 100;
                } else {
                    $uniteAtk = $allOnGoingAtk[$i]->getUnitsAtk();
                }

                $allBuildUserEnemi = array();
                $planetAtk = $allOnGoingAtk[$i]->getPlanets();
                for ($j=0; $j < $planetAtk->getPlayers()->count(); $j++) {
                    $BuildUserEnemie = $planetAtk->getPlayers()[$j]->getBatimentsOwned();
                    for ($k=0; $k < $BuildUserEnemie->count(); $k++) {
                        $allBuildUserEnemi[] = $BuildUserEnemie[$k];
                    }
                }

                dump($uniteAtk);

                while ($uniteAtk > 0) {
                    $planetDeafet = true;
                    for ($j=0; $j < count($allBuildUserEnemi); $j++) {
                        if ($allBuildUserEnemi[$j]->getHp()) {
                            $planetDeafet = false;
                        }
                    }
                    if ($planetDeafet)
                        break;
                    $BuildUserEnemi = $allBuildUserEnemi[rand(0, count($allBuildUserEnemi) - 1)];
                    if ($BuildUserEnemi->getHp()) {
                        $BuildUserEnemi->setHp($BuildUserEnemi->getHp() - 1);
                        $em->persist($BuildUserEnemi);
                        $uniteAtk--;
                    }
                }
                $user->setUnits($user->getUnits() + $uniteAtk);
                $allOnGoingAtk[$i]->setIdEnded(true);
                $em->persist($allOnGoingAtk[$i]);
                $em->persist($user);
            }
        }
        $em->flush();
    }

    public function GoldUnitsUpdater(ManagerRegistry $doctrine, User $user)
    {
        $em = $doctrine->getManager();

        $dateNow = new \DateTime('now');
        $buildingsOwned = $user->getBatimentsOwned();
        $needToAddInTime = $user->getLastUpdate()->diff($dateNow);
        $needToAddInTime = $needToAddInTime->s + $needToAddInTime->i * 60 + $needToAddInTime->h * 3600 + $needToAddInTime->d * 86400;
        $addGold = $user->getGold();
        $addUnites = $user->getUnits();

        $addGoldPerTechnologies = 0;

        for ($i=0; $i < count($user->getUserTechnoOwned()); $i++) {
            $addGoldPerTechnologies = (
                $user->getUserTechnoOwned()[$i]->getLevel() *
                $user->getUserTechnoOwned()[$i]->getType()->getGoldBoostPerLevel()
            );
        }

        for ($i=0; $i < count($buildingsOwned); $i++) {
            if ($buildingsOwned[$i]->getHp() && !$buildingsOwned[$i]->getUpgrading()) {
                $addGold += (
                    (($buildingsOwned[$i]->getType()->getGoldPerHour() / 3600) + 
                    ($addGoldPerTechnologies / 3600)) * 
                    $needToAddInTime
                );
                $addUnites += ($buildingsOwned[$i]->getType()->getUnitesPerHour() / 3600) * $needToAddInTime;
            }
        }

        $user->setGold($addGold)
                    ->setUnits($addUnites)
                    ->setlastUpdate($dateNow);

        $em->persist($user);
        $em->flush();
    }
}