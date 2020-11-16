<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Inamika\BackEndBundle\Entity\Project;
use Inamika\BackEndBundle\Entity\Unit;
use Inamika\BackEndBundle\Entity\ProjectLevels;
use Inamika\BackEndBundle\Entity\Maps;
use Inamika\BackEndBundle\Form\Project\ProjectType;
use Inamika\BackEndBundle\Form\Project\ProjectEditType;
use Inamika\BackEndBundle\Entity\Gallery;

class ProjectsController extends BaseController
{   
    public function indexAction(Request $request){
        $search = $request->query->get('search', array());
        $query=(!isset($search['value']))?'':$search['value'];
        $offset = $request->query->get('start', 0);
        $limit = $request->query->get('length', 30);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);
        $this->getDoctrine()->getRepository(Project::class)->user=$this->get('security.token_storage')->getToken()->getUser();
        return $this->handleView($this->view(array(
            'data' => $this->getDoctrine()->getRepository(Project::class)->search($query, $limit, $offset, $sort, $direction)->getQuery()->getResult(),
            'recordsTotal' => $this->getDoctrine()->getRepository(Project::class)->total(),
            'recordsFiltered' => $this->getDoctrine()->getRepository(Project::class)->searchTotal($query, $limit, $offset),
            'offset' => $offset,
            'limit' => $limit,
        )));
    }
    
    public function getAction($id){
        if(!$entity=$this->getDoctrine()->getRepository(Project::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        return $this->handleView($this->view($entity));
    }
    
    public function unitsAction($id){
        if(!$entity=$this->getDoctrine()->getRepository(Project::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        $entities=$this->getDoctrine()->getRepository(Unit::class)->getAll()->andWhere('e.project=:project')->setParameter('project',$entity->getId())->getQuery()->getResult();
        return $this->handleView($this->view($entities));
    }
    
    public function unitsTotalAction($id){
        if(!$entity=$this->getDoctrine()->getRepository(Project::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        $entities=$this->getDoctrine()->getRepository(Unit::class)->getTotalByStatus($entity)->getQuery()->getResult();
        return $this->handleView($this->view($entities));
    }

    public function postAction(Request $request){
        $entity = new Project();
        $form = $this->createForm(ProjectEditType::class, $entity);
        $content=json_decode($request->getContent(), true);
        $form->submit($content);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            /** Gallery */
            if(isset($content['gallery']))
                $this->uploadsGallery($entity,$content['gallery']);

            /** Map */
            if($form->get('mapBase64')->getData())
                $entity->setMap($this->base64ToFile($form->get('mapBase64')->getData(),"uploads/"));
            $em->flush();
            return $this->handleView($this->view($entity, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }
    
    public function levelsAction(Request $request,$id){
        if(!$project=$this->getDoctrine()->getRepository(Project::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        $content=json_decode($request->getContent(), true);
        if(!is_array($content))
            return $this->handleView($this->view(null, Response::HTTP_BAD_REQUEST));
        $em = $this->getDoctrine()->getManager();
        $idsExists=[];
        foreach ($content as $key => $level) {
            if(!$projectLevels=$this->getDoctrine()->getRepository(projectLevels::class)->find($level['id']))
                $projectLevels= new ProjectLevels();
            $idsExists[]=$level["id"];
            $projectLevels->setName($level['name']);
            $projectLevels->setDescription($level['description']);
            $projectLevels->setProject($project);
            /** Map */
            if(isset($level['mapBase64']) && $level['mapBase64'])
                $projectLevels->setMap($this->base64ToFile($level['mapBase64'],"uploads/"));
            else if(isset($level['mapRemove']) && $level['mapRemove'])
                $projectLevels->setMap(null);

            $em->persist($projectLevels);
        }
        /** Remove  */
        foreach ($project->getLevels() as $key => $item) 
            if(!in_array($item->getId(),$idsExists)) 
                $em->remove($item);
        $em->flush();
        return $this->handleView($this->view($content, Response::HTTP_OK));

        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }
    
    public function putAction(Request $request,$id){
        if(!$entity=$this->getDoctrine()->getRepository(Project::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        $form = $this->createForm(ProjectType::class, $entity);
        $content=json_decode($request->getContent(), true);
        $fileOld=$entity->getMap();
        $form->submit($content);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            /** Gallery */
            if(isset($content['gallery']))
                $this->uploadsGallery($entity,$content['gallery']);
                
            /** Map */
            if($form->get('mapBase64')->getData())
                $fileOld=$this->base64ToFile($form->get('mapBase64')->getData(),"uploads/");
            else if($form->get('mapRemove')->getData()) $fileOld=null;
            $entity->setMap($fileOld);
            $em->flush();
            return $this->handleView($this->view($entity, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

    public function deleteAction(Request $request,$id){
        if(!$entity=$this->getDoctrine()->getRepository(Project::class)->find($id))
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
                $gallery->setProject($entity);
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