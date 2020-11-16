<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackOfficeBundle\Controller;

use Inamika\BackEndBundle\Entity\ProjectLevels;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Generator\UrlGenerator;

class ProjectsLevelsController extends BaseController{	
    
    public function blocksAction($id){
        $entity=$this->getDoctrine()->getRepository(ProjectLevels::class)->find($id);
        return $this->render('InamikaBackOfficeBundle:ProjectsLevels:blocks.html.twig',array(
            'entity'=>$entity,
            'mapSize'=>getimagesize('uploads/xl/'.$entity->getMap())
        ));
	}
}
