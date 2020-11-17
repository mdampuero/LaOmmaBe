<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackOfficeBundle\Controller;

use Inamika\BackEndBundle\Entity\Menu;
use Inamika\BackEndBundle\Form\Menu\MenuType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Generator\UrlGenerator;

class MenusController extends BaseController{

	public function indexAction(){
		return $this->render('InamikaBackOfficeBundle:Menus:index.html.twig',array(
            'formDelete'=>$this->createFormBuilder()
            ->setAction($this->generateUrl('api_menus_delete', array('id' => ':ENTITY_ID')))
            ->setMethod('DELETE')
            ->getForm()->createView(),
        ));
	}

	public function addAction(){
		return $this->render('InamikaBackOfficeBundle:Menus:form.html.twig',array('entity'=>new Menu()));
    }	
    
    public function editAction($id){
        return $this->render('InamikaBackOfficeBundle:Menus:form.html.twig',array('entity'=>$this->getDoctrine()->getRepository(Menu::class)->find($id)));
    }
    
    public function landingAction($id){
        return $this->render('InamikaBackOfficeBundle:Menus:landing.html.twig',array('id'=>$id));
    }

    public function getAction($id){
        return $this->render('InamikaBackOfficeBundle:Menus:_partials/get.html.twig',array('entity'=>$this->getDoctrine()->getRepository(Menu::class)->find($id)));
    }

    public function importAction(){
		return $this->render('InamikaBackOfficeBundle:Menus:import.html.twig',array(
			'form' => $this->createForm(ImportType::class, null,array(
                'method' => 'POST',
                'action' => $this->generateUrl('api_menus_import')
            ))->createView()
        ));
    }
    
	public function form($entity){
        $method='POST';
        $action=$this->generateUrl('api_menus_post');
        if($entity->getId()){
            $method='PUT';
            $action=$this->generateUrl('api_menus_put',array('id'=>$entity->getId()));
        }
		return $this->render('InamikaBackOfficeBundle:Menus:_partials/form.html.twig',array(
			'form' => $this->createForm(MenuType::class, $entity,array(
                'method' => $method,
                'action' => $action
            ))->createView()
        ));
    }
}
