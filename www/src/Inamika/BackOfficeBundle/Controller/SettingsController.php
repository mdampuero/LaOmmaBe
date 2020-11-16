<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackOfficeBundle\Controller;

use Inamika\BackEndBundle\Entity\Setting;
use Inamika\BackEndBundle\Form\Setting\SettingType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Generator\UrlGenerator;


class SettingsController extends BaseController{

	public function indexAction(){
        $entity=$this->getDoctrine()->getRepository(Setting::class)->find('setting');
        return $this->render('InamikaBackOfficeBundle:Settings:form.html.twig',array(
            'entity'=>$entity,
			'form' => $this->createForm(SettingType::class, $entity,array(
                'method' => 'PUT',
                'action' => $this->generateUrl('api_settings_put',array('id'=>'setting'))
            ))->createView()
        ));
	}
}
