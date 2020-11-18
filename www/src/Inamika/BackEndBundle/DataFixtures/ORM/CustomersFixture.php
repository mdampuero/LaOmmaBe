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
use Inamika\BackEndBundle\Entity\Customer;
use Inamika\BackEndBundle\Entity\Currency;

class CustomersFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{

    private $container;

    public function setContainer(ContainerInterface $container = null){
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager){
        for ($i=1; $i<=10; $i++){
            $customer = new Customer();
            $customer->setName("Cliente - ".$i);
            $customer->setEmail("cliente".$i."@email.com");
            $customer->setPhone("11122225555".$i);
            $customer->setPassword("123456");
            $manager->persist($customer);
        }
        $manager->flush();
    }
    
    public function getOrder(){
        return 7;
    }
}
