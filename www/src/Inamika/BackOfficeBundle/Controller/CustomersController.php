<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackOfficeBundle\Controller;

use Inamika\BackEndBundle\Entity\Customer;
use Inamika\BackEndBundle\Form\Customer\CustomerType;
use Inamika\BackEndBundle\Form\Customer\ImportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Generator\UrlGenerator;

class CustomersController extends BaseController{

	public function indexAction(){
		return $this->render('InamikaBackOfficeBundle:Customers:index.html.twig',array(
            'formDelete'=>$this->createFormBuilder()
            ->setAction($this->generateUrl('api_customers_delete', array('id' => ':ENTITY_ID')))
            ->setMethod('DELETE')
            ->getForm()->createView(),
        ));
	}

	public function addAction(){
		return $this->render('InamikaBackOfficeBundle:Customers:form.html.twig',array('entity'=>new Customer()));
    }	
    
    public function editAction($id){
        return $this->render('InamikaBackOfficeBundle:Customers:form.html.twig',array('entity'=>$this->getDoctrine()->getRepository(Customer::class)->find($id)));
    }
    
    public function landingAction($id){
        return $this->render('InamikaBackOfficeBundle:Customers:landing.html.twig',array('id'=>$id));
    }

    public function getAction($id){
        return $this->render('InamikaBackOfficeBundle:Customers:_partials/get.html.twig',array('entity'=>$this->getDoctrine()->getRepository(Customer::class)->find($id)));
    }

    public function importAction(){
		return $this->render('InamikaBackOfficeBundle:Customers:import.html.twig',array(
			'form' => $this->createForm(ImportType::class, null,array(
                'method' => 'POST',
                'action' => $this->generateUrl('api_customers_import')
            ))->createView()
        ));
    }
    
	public function form($entity){
        $method='POST';
        $action=$this->generateUrl('api_customers_post');
        if($entity==null) $entity=new Customer();
        if($entity->getId()){
            $method='PUT';
            $action=$this->generateUrl('api_customers_put',array('id'=>$entity->getId()));
        }
		return $this->render('InamikaBackOfficeBundle:Customers:_partials/form.html.twig',array(
			'form' => $this->createForm(CustomerType::class, $entity,array(
                'method' => $method,
                'action' => $action
            ))->createView()
        ));
    }

}
