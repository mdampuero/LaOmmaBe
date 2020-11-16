<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackOfficeBundle\Controller;

use Inamika\BackEndBundle\Entity\Demo;
use Inamika\BackEndBundle\Form\Demo\DemoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Generator\UrlGenerator;

class DemosController extends BaseController{

	public function indexAction(){
		return $this->render('InamikaBackOfficeBundle:Demos:index.html.twig',array(
            'formDelete'=>$this->createFormBuilder()
            ->setAction($this->generateUrl('api_demos_delete', array('id' => ':ENTITY_ID')))
            ->setMethod('DELETE')
            ->getForm()->createView(),
        ));
	}

	public function addAction(){
		return $this->render('InamikaBackOfficeBundle:Demos:form.html.twig',array('entity'=>new Demo()));
    }	
    
    public function editAction($id){
        return $this->render('InamikaBackOfficeBundle:Demos:form.html.twig',array('entity'=>$this->getDoctrine()->getRepository(Demo::class)->find($id)));
    }
    
    public function landingAction($id){
        return $this->render('InamikaBackOfficeBundle:Demos:landing.html.twig',array('id'=>$id));
    }

    public function getAction($id){
        return $this->render('InamikaBackOfficeBundle:Demos:_partials/get.html.twig',array('entity'=>$this->getDoctrine()->getRepository(Demo::class)->find($id)));
    }

    public function importAction(){
		return $this->render('InamikaBackOfficeBundle:Demos:import.html.twig',array(
			'form' => $this->createForm(ImportType::class, null,array(
                'method' => 'POST',
                'action' => $this->generateUrl('api_demos_import')
            ))->createView()
        ));
    }
    
	public function form($entity){
        $method='POST';
        $action=$this->generateUrl('api_demos_post');
        if($entity->getId()){
            $method='PUT';
            $action=$this->generateUrl('api_demos_put',array('id'=>$entity->getId()));
        }
		return $this->render('InamikaBackOfficeBundle:Demos:_partials/form.html.twig',array(
			'form' => $this->createForm(DemoType::class, $entity,array(
                'method' => $method,
                'action' => $action
            ))->createView()
        ));
    }
}
