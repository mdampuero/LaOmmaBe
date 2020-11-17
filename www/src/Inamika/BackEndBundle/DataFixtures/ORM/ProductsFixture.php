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
use Inamika\BackEndBundle\Entity\Product;
use Inamika\BackEndBundle\Entity\Currency;

class ProductsFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{

    private $container;

    public function setContainer(ContainerInterface $container = null){
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager){
        for ($i=1; $i<=100; $i++){
            $menu = new Product();
            $menu->setName("Plato - ".$i);
            $menu->setCode("AA".$i);
            $menu->setPrice($i*1.10);
            $menu->setCurrency($manager->getRepository(Currency::class)->findOneByIsDefault(true));
            $menu->setDescription("Description menu - ".$i);
            $manager->persist($menu);
        }
        $manager->flush();
    }
    
    public function getOrder(){
        return 5;
    }
}
