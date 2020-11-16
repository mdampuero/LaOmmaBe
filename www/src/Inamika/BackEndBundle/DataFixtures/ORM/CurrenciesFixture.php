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
use Inamika\BackEndBundle\Entity\Currency;

class CurrenciesFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{

    private $container;

    public function setContainer(ContainerInterface $container = null){
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager){
        $ARS = new Currency();
        $ARS->setId(Currency::ARS);
        $ARS->setName("Peso Argentino");
        $ARS->setCode(Currency::ARS);
        $ARS->setSymbol("$");
        $manager->persist($ARS);
        $USD = new Currency();
        $USD->setId(Currency::USD);
        $USD->setName("Dólar");
        $USD->setCode(Currency::USD);
        $USD->setSymbol('U$D');
        $manager->persist($USD);
        
        $manager->flush();
    }
    
    public function getOrder(){
        return 6;
    }
}
