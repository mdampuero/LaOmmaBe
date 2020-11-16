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
use Inamika\BackEndBundle\Entity\ProjectType;

class ProjectsTypeFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{

    private $container;

    public function setContainer(ContainerInterface $container = null){
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager){
        $NEIGHBORHOOD = new ProjectType();
        $NEIGHBORHOOD->setId(ProjectType::NEIGHBORHOOD);
        $NEIGHBORHOOD->setName("Barrio");
        $manager->persist($NEIGHBORHOOD);
        $CONDOMINIUM = new ProjectType();
        $CONDOMINIUM->setId(ProjectType::CONDOMINIUM);
        $CONDOMINIUM->setName("Condominio");
        $manager->persist($CONDOMINIUM);
        $manager->flush();
    }
    
    public function getOrder(){
        return 4;
    }
}
