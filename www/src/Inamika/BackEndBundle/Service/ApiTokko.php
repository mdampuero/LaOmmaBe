<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackEndBundle\Service;
use Symfony\Component\HttpClient\HttpClient;
use Doctrine\ORM\EntityManager;

/**
 * Class ApiTokko
 *
 * @package Inamika\BackEndBundle\Service
 */
class ApiTokko
{
    protected $em;
    protected $setting;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->setting=$this->em->getRepository('InamikaBackEndBundle:Setting')->find('setting');
    }

    /**
     * @return array
     */
    public function development($development_id=null,$limit=30,$offset=0){
        $params="&limit=".$limit."&offset=".$offset;
        $response = HttpClient::create()->request('GET', $this->setting->getTokkoUrl().'development?key='.$this->setting->getTokkoKey().'&format=json&lang=es_ar'.$params);
        if($response->getStatusCode()!=200)
            return false;
        return json_decode($response->getContent());
    }
    
    /**
     * @return array
     */
    public function property($development_id=null,$limit=30,$offset=0){
        $params="&limit=".$limit."&offset=".$offset;
        if($development_id)
            $params.="&development__id=".$development_id;
        $response = HttpClient::create()->request('GET', $this->setting->getTokkoUrl().'property?key='.$this->setting->getTokkoKey().'&format=json&lang=es_ar'.$params);
        if($response->getStatusCode()!=200)
            return false;
        return json_decode($response->getContent());
    }
    
}