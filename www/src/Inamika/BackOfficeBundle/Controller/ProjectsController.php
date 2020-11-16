<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackOfficeBundle\Controller;

use Inamika\BackEndBundle\Entity\Project;
use Inamika\BackEndBundle\Entity\Unit;
use Inamika\BackEndBundle\Entity\UnitStatus;
use Inamika\BackEndBundle\Entity\UnitType;
use Inamika\BackEndBundle\Form\Project\ProjectType;
use Inamika\BackEndBundle\Form\Project\ProjectEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Generator\UrlGenerator;

class ProjectsController extends BaseController{

	public function indexAction(){
		return $this->render('InamikaBackOfficeBundle:Projects:index.html.twig',array(
            'formDelete'=>$this->createFormBuilder()
            ->setAction($this->generateUrl('api_projects_delete', array('id' => ':ENTITY_ID')))
            ->setMethod('DELETE')
            ->getForm()->createView(),
        ));
	}

	public function addAction(){
		return $this->render('InamikaBackOfficeBundle:Projects:form.html.twig',array(
			'form' => $this->createForm(ProjectType::class, new Project(),array(
                'method' => 'POST',
                'action' => $this->generateUrl('api_projects_post')
            ))->createView()
        ));
	}	

	public function editAction($id){
        $entity=$this->getDoctrine()->getRepository(Project::class)->find($id);
        return $this->render('InamikaBackOfficeBundle:Projects:form.html.twig',array(
            'entity'=>$entity,
			'form' => $this->createForm(ProjectEditType::class, $entity,array(
                'method' => 'PUT',
                'action' => $this->generateUrl('api_projects_put',array('id'=>$id))
            ))->createView()
        ));
	}
    
    public function landingAction($id){
        $entity=$this->getDoctrine()->getRepository(Project::class)->find($id);
        return $this->render('InamikaBackOfficeBundle:Projects:landing.html.twig',array(
            'entity'=>$entity,
            'unitStatus'=>$this->getDoctrine()->getRepository(UnitStatus::class)->getAll()->getQuery()->getResult(),
            'unitType'=>$this->getDoctrine()->getRepository(UnitType::class)->getAll()->getQuery()->getResult(),
            'mapSize'=>getimagesize('uploads/or/'.$entity->getMap())
        ));
	}
    
    public function modulesAction($id){
        $entity=$this->getDoctrine()->getRepository(Project::class)->find($id);
        if(!$entity->getMap()){
            $this->addFlash("danger", $this->get('translator')->trans('YOU_HAVE_NOT_ENTERED_ANY_MAP'));
            return $this->redirectToRoute('inamika_backoffice_projects');
        }
        return $this->render('InamikaBackOfficeBundle:Projects:modules.html.twig',array('entity'=>$entity,'mapSize'=>getimagesize('uploads/xl/'.$entity->getMap())));
	}
    
    public function mapAction($id){
        $entity=$this->getDoctrine()->getRepository(Project::class)->find($id);
        if(!$entity->getMap()){
            $this->addFlash("danger", $this->get('translator')->trans('YOU_HAVE_NOT_ENTERED_ANY_MAP'));
            return $this->redirectToRoute('inamika_backoffice_projects');
        }
        return $this->render('InamikaBackOfficeBundle:Projects:map.html.twig',array(
            'unit'=>new Unit(),
            'entity'=>$entity,
            'mapSize'=>getimagesize('uploads/or/'.$entity->getMap())
        ));
	}
}
