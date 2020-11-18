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
use Inamika\BackEndBundle\Entity\OrdersStatus;

class OrdersStatusFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{

    private $container;

    public function setContainer(ContainerInterface $container = null){
        $this->container = $container;
    }
    // const STATUS_ENTERED='ENTERED';
    // const STATUS_IN_PROCCESS='IN_PROCCESS';
    // const STATUS_ON_DELIVERY='ON_DELIVERY';
    // const STATUS_DELIVERED='DELIVERED';
    // const STATUS_CANCELLED='CANCELLED';
    public function load(ObjectManager $manager){
        $ordersStatus = new OrdersStatus();
        $ordersStatus->setId(OrdersStatus::STATUS_ENTERED);
        $ordersStatus->setName('Ingresado');
        $ordersStatus->setColor("info");
        $ordersStatus->setIsDefault(true);
        $manager->persist($ordersStatus);
        
        $ordersStatus = new OrdersStatus();
        $ordersStatus->setId(OrdersStatus::STATUS_IN_PROCCESS);
        $ordersStatus->setName('En proceso');
        $ordersStatus->setColor("primary");
        $ordersStatus->setIsDefault(false);
        $manager->persist($ordersStatus);
        
        $ordersStatus = new OrdersStatus();
        $ordersStatus->setId(OrdersStatus::STATUS_ON_DELIVERY);
        $ordersStatus->setName('En entrega');
        $ordersStatus->setColor("warning");
        $ordersStatus->setIsDefault(false);
        $manager->persist($ordersStatus);
        
        $ordersStatus = new OrdersStatus();
        $ordersStatus->setId(OrdersStatus::STATUS_DELIVERED);
        $ordersStatus->setName('Entregado');
        $ordersStatus->setColor("success");
        $ordersStatus->setIsDefault(false);
        $manager->persist($ordersStatus);
        
        $ordersStatus = new OrdersStatus();
        $ordersStatus->setId(OrdersStatus::STATUS_CANCELLED);
        $ordersStatus->setName('Cancelado');
        $ordersStatus->setColor("danger");
        $ordersStatus->setIsDefault(false);
        $manager->persist($ordersStatus);

        $manager->flush();
    }
    
    public function getOrder(){
        return 6;
    }
}
