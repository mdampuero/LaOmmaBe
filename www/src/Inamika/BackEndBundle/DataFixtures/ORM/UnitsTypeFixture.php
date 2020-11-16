<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackEndBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Inamika\BackEndBundle\Entity\UnitType;

class UnitsTypeFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{

    private $container;

    public function setContainer(ContainerInterface $container = null){
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager){
        $HOUSE = new UnitType();
        $HOUSE->setId(UnitType::HOUSE);
        $HOUSE->setName("Casa");
        $HOUSE->setIcon("fa fa-home");
        $manager->persist($HOUSE);
        $LOT = new UnitType();
        $LOT->setId(UnitType::LOT);
        $LOT->setName("Lote");
        $LOT->setIcon(UnitType::DEFAULT_ICON);
        $manager->persist($LOT);
        $manager->flush();
        $BUILDING = new UnitType();
        $BUILDING->setId(UnitType::BUILDING);
        $BUILDING->setName("Construcción");
        $BUILDING->setIcon("mdi mdi-wrench");
        $manager->persist($BUILDING);
        $manager->flush();
    }
    
    public function getOrder(){
        return 5;
    }
}
