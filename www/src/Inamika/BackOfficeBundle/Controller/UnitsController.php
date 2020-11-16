<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackOfficeBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Inamika\BackEndBundle\Entity\Unit;
use Inamika\BackEndBundle\Form\Unit\UnitType;
use Inamika\BackEndBundle\Form\Unit\ImportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Generator\UrlGenerator;

class UnitsController extends BaseController{

	public function indexAction(){
		return $this->render('InamikaBackOfficeBundle:Units:index.html.twig',array(
            'formDelete'=>$this->createFormBuilder()
            ->setAction($this->generateUrl('api_units_delete', array('id' => ':ENTITY_ID')))
            ->setMethod('DELETE')
            ->getForm()->createView(),
        ));
	}

	public function addAction(Request $request){
        if($request->query->get('disableLayout', 0) == 1)
            return $this->render('InamikaBackOfficeBundle:Units:formModal.html.twig',array('entity'=>new Unit()));
        else 
            return $this->render('InamikaBackOfficeBundle:Units:form.html.twig',array('entity'=>new Unit()));
    }
    
    public function editAction(Request $request,$id){
        if($request->query->get('disableLayout', 0) == 1)
            return $this->render('InamikaBackOfficeBundle:Units:formModal.html.twig',array('entity'=>$this->getDoctrine()->getRepository(Unit::class)->find($id)));
        else
            return $this->render('InamikaBackOfficeBundle:Units:form.html.twig',array('entity'=>$this->getDoctrine()->getRepository(Unit::class)->find($id)));
    }
    
    public function landingAction($id){
        return $this->render('InamikaBackOfficeBundle:Units:landing.html.twig',array('id'=>$id));
    }

    public function getAction($id){
        return $this->render('InamikaBackOfficeBundle:Units:_partials/get.html.twig',array('entity'=>$this->getDoctrine()->getRepository(Unit::class)->find($id)));
    }

    public function importAction(){
		return $this->render('InamikaBackOfficeBundle:Units:import.html.twig',array(
			'form' => $this->createForm(ImportType::class, null,array(
                'method' => 'POST',
                'action' => $this->generateUrl('api_units_import')
            ))->createView()
        ));
    }

    public function tokkoAction(Request $request){
		return $this->render('InamikaBackOfficeBundle:Units:tokko.html.twig',['data'=>$this->get('ApiTokko')->property($request->get('development_id'))]);
    }
    
	public function form($entity){
        $method='POST';
        $action=$this->generateUrl('api_units_post');
        if($entity->getId()){
            $method='PUT';
            $action=$this->generateUrl('api_units_put',array('id'=>$entity->getId()));
        }
		return $this->render('InamikaBackOfficeBundle:Units:_partials/form.html.twig',array(
            'entity'=>$entity,
			'form' => $this->createForm(UnitType::class, $entity,array(
                'method' => $method,
                'action' => $action
            ))->createView()
        ));
    }
}