<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Inamika\BackEndBundle\Entity\Unit;
use Inamika\BackEndBundle\Entity\Log;
use Inamika\BackEndBundle\Form\Unit\UnitType;
use Inamika\BackEndBundle\Form\Unit\ImportType;
use Inamika\BackEndBundle\Entity\Gallery;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class UnitsController extends BaseController
{   
    public function indexAction(Request $request){
        $search = $request->query->get('search', array());
        $query=(!isset($search['value']))?'':$search['value'];
        $offset = $request->query->get('start', 0);
        $limit = $request->query->get('length', 30);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);
        $this->getDoctrine()->getRepository(Unit::class)->user=$this->get('security.token_storage')->getToken()->getUser();
        return $this->handleView($this->view(array(
            'data' => $this->getDoctrine()->getRepository(Unit::class)->search($query, $limit, $offset, $sort, $direction)->getQuery()->getResult(),
            'recordsTotal' => $this->getDoctrine()->getRepository(Unit::class)->total(),
            'recordsFiltered' => $this->getDoctrine()->getRepository(Unit::class)->searchTotal($query, $limit, $offset),
            'offset' => $offset,
            'limit' => $limit,
        )));
    }

    public function logsAction($id){
        return $this->handleView($this->view($this->getDoctrine()->getRepository(Log::class)->findByResource("units_comments_${id}",array('createdAt'=>'DESC'))));
    }
    
    public function getAction($id){
        if(!$entity=$this->getDoctrine()->getRepository(Unit::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        return $this->handleView($this->view($entity));
    }

    public function postAction(Request $request){
        $entity = new Unit();
        $form = $this->createForm(UnitType::class, $entity);
        $content=json_decode($request->getContent(), true);
        $form->submit($content);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);

            /** Gallery */
            if(isset($content['gallery']))
                $this->uploadsGallery($entity,$content['gallery']);

            $em->flush();
            return $this->handleView($this->view($entity, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }
    
    public function importAction(Request $request){
        $form = $this->createForm(ImportType::class, null);
        $content=json_decode($request->getContent(), true);
        $form->submit($content);
        if ($form->isSubmitted() && $form->isValid()) {
            $path='uploads/or/';
            try {
                if(empty($content["file"]))
                    throw new Exception("El formato del archivo debe ser XLSX");
                $file=$this->get('Base64Service')->convertToFile($content["file"]["base64"],$path);
                $extension=explode('.',$file);
                if(strtoupper(end($extension))!='XLSX')
                    throw new Exception("El formato del archivo debe ser XLSX");
                $this->getDoctrine()->getRepository(Unit::class)->importEXCEL($this->get('phpoffice.spreadsheet')->createSpreadsheet($path.$file));
                return $this->handleView($this->view("", Response::HTTP_OK));
            } catch (\Throwable $th) {
                $response=["form"=>[
                    "code"=>400,
                    "message"=>"Validation Failed",
                    "errors"=>[
                        "children"=>[
                            "file"=>[
                                "errors"=>['<br>'.$th->getMessage()]
                            ]
                        ]
                    ]
                ]];
                return $this->handleView($this->view($response, Response::HTTP_BAD_REQUEST));
            }
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }
    
    public function exportAction(Request $request){
        $file=$this->getDoctrine()->getRepository(Unit::class)->exportEXCEL($this->get('phpoffice.spreadsheet')->createSpreadsheet());
        $response = new BinaryFileResponse($file);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
        return $response;
    }

    public function putAction(Request $request,$id){
        if(!$entity=$this->getDoctrine()->getRepository(Unit::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        $form = $this->createForm(UnitType::class, $entity);
        $content=json_decode($request->getContent(), true);
        $form->submit($content);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            /** Gallery */
            if(isset($content['gallery']))
                $this->uploadsGallery($entity,$content['gallery']);
            $em->flush();
            return $this->handleView($this->view($entity, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

    public function positionAction(Request $request,$id){
        if(!$entity=$this->getDoctrine()->getRepository(Unit::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        $content=json_decode($request->getContent(), true);
        if (key_exists('x',$content) && key_exists('y',$content)) {
            $em = $this->getDoctrine()->getManager();
            $diff=$content["zoom"]-100;
            $direction=($diff>0)?1:-1;
            $count=abs($diff/$content["step"]);
            $newY=$content['y'];
            $newX=$content['x'];
            for($i=1; $i<=$count;$i++){
                $newY=(int)($newY/((100+$content["step"]*$direction)/100));
                $newX=(int)($newX/((100+$content["step"]*$direction)/100));
            }
            $entity->setSvgY($newY);
            $entity->setSvgX($newX);
            $em->persist($entity);
            $em->flush();
            return $this->handleView($this->view($entity, Response::HTTP_OK));
        }
        return $this->handleView($this->view("", Response::HTTP_BAD_REQUEST));
    }

    public function deleteAction(Request $request,$id){
        if(!$entity=$this->getDoctrine()->getRepository(Unit::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        $form = $this->createFormBuilder(null, array('csrf_protection' => false))->setMethod('DELETE')->getForm();
        $form->submit(json_decode($request->getContent(), true));
        if ($form->isSubmitted() && $form->isValid()){
            $entity->setIsDelete(true);
            $this->getDoctrine()->getManager()->flush();
            return $this->handleView($this->view($entity, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

    public function uploadsGallery($entity,$elementsGallery=[]){
        $em = $this->getDoctrine()->getManager();
        $idsExists=[];
        /** Add */
        foreach($elementsGallery as $item){
            if(!$item["id"]){
                $gallery = new Gallery();
                $gallery->setUnit($entity);
                $gallery->setType($item['type']);
                switch($item['type']){
                    case 'image':
                        $gallery->setValue($this->base64ToFile($item['data']));
                    break;
                    case 'youtube':
                        $gallery->setValue($item['data']);
                    break;
                }
                $em->persist($gallery);
            }else $idsExists[]=$item["id"];
        }
        /** Remove  */
        foreach ($entity->getGallery() as $key => $item) 
            if(!in_array($item->getId(),$idsExists)) 
                $em->remove($item);
        
        $em->flush();
        return true;
    }
}