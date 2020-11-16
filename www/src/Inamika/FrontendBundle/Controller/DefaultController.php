<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller{
    
    public function indexAction(){
        return $this->redirectToRoute('inamika_backoffice_homepage');
        // return $this->render('InamikaFrontendBundle:Default:index.html.twig');
    }
}
