<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackOfficeBundle\Controller;

use Inamika\BackEndBundle\Entity\UnitType;
use Inamika\BackEndBundle\Form\UnitType\UnitTypeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Generator\UrlGenerator;

class UnitsTypesController extends BaseController{

	public function indexAction(){
		return $this->render('InamikaBackOfficeBundle:UnitsTypes:index.html.twig',array(
            'formDelete'=>$this->createFormBuilder()
            ->setAction($this->generateUrl('api_unitsTypes_delete', array('id' => ':ENTITY_ID')))
            ->setMethod('DELETE')
            ->getForm()->createView(),
        ));
	}

	public function addAction(){
		return $this->render('InamikaBackOfficeBundle:UnitsTypes:form.html.twig',array('entity'=>new UnitType()));
    }	
    
    public function editAction($id){
        return $this->render('InamikaBackOfficeBundle:UnitsTypes:form.html.twig',array('entity'=>$this->getDoctrine()->getRepository(UnitType::class)->find($id)));
    }
    
    public function landingAction($id){
        return $this->render('InamikaBackOfficeBundle:UnitsTypes:landing.html.twig',array('id'=>$id));
    }

    public function getAction($id){
        return $this->render('InamikaBackOfficeBundle:UnitsTypes:_partials/get.html.twig',array('entity'=>$this->getDoctrine()->getRepository(UnitType::class)->find($id)));
    }

	public function form($entity){
        $method='POST';
        $action=$this->generateUrl('api_unitsTypes_post');
        if($entity->getId()){
            $method='PUT';
            $action=$this->generateUrl('api_unitsTypes_put',array('id'=>$entity->getId()));
        }
		return $this->render('InamikaBackOfficeBundle:UnitsTypes:_partials/form.html.twig',array(
			'form' => $this->createForm(UnitTypeType::class, $entity,array(
                'method' => $method,
                'action' => $action
            ))->createView()
        ));
    }
}
