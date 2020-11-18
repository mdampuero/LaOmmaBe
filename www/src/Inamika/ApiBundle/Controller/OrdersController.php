<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Inamika\BackEndBundle\Entity\Orders;
use Inamika\BackEndBundle\Entity\OrdersStatus;
use Inamika\BackEndBundle\Entity\Log;
use Inamika\BackEndBundle\Entity\OrdersItem;
use Inamika\BackEndBundle\Entity\OrdersTotal;
use Inamika\BackEndBundle\Entity\Product;
use Inamika\BackEndBundle\Entity\Currency;
use Inamika\BackEndBundle\Form\Order\OrderType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Config\Definition\Exception\Exception;

class OrdersController extends FOSRestController
{
    public function indexAction(Request $request)
    {
        $search = $request->query->get('search', array());
        $offset = $request->query->get('start', 0);
        $limit = $request->query->get('length', 30);
        $sort = $request->query->get('sort', null);
        $direction = $request->query->get('direction', null);
        return $this->handleView($this->view(array(
            'data' => $this->getDoctrine()->getRepository(Orders::class)->search($search["value"], $limit, $offset, $sort, $direction)->getQuery()->getResult(),
            'recordsTotal' => $this->getDoctrine()->getRepository(Orders::class)->total(),
            'recordsFiltered' => $this->getDoctrine()->getRepository(Orders::class)->searchTotal($search["value"], $limit, $offset),
            'offset' => $offset,
            'limit' => $limit,
        )));
    }

    public function postAction(Request $request){
        try{
            $entity = new Orders();
            $form = $this->createForm(OrderType::class, $entity);
            $content=json_decode($request->getContent(), true);
            $form->submit($content);
            if ($form->isSubmitted() && $form->isValid()) {
                $entity->setStatus($this->getDoctrine()->getRepository(OrdersStatus::class)->findOneByIsDefault(true));
                $em = $this->getDoctrine()->getManager();
                if(!isset($content['items']))
                    throw new Exception("Este valor no debería estar vacío.");
                $items=$content['items'];
                if(count($items)<=0)
                    throw new Exception("Este valor no debería estar vacío.");
                $itemsArray=[];
                foreach ($items as $key => $item) {
                    if(!$menuEntity=$em->getRepository(Product::class)->find($item["id"]))
                        throw new Exception("Este valor {$item['id']} no es válido.");
                    $ordersItem=new OrdersItem();
                    $ordersItem->setProduct($menuEntity);
                    $ordersItem->setOrder($entity);
                    $ordersItem->setCode($item["code"]);
                    $ordersItem->setQuantity($item["quantity"]);
                    $ordersItem->setDescription($item["name"]);
                    $ordersItem->setPrice($item["price"]);
                    $ordersItem->setSubtotal($item["price"]*$item["quantity"]);
                    $em->persist($ordersItem);
                    $itemsArray[]=$ordersItem;
                }
                $entity->setItems($itemsArray);
                $em->persist($entity);
                $em->flush();

                /** LOG */
                $log = new Log();
                $log->setTitle('Nuevo pedido');
                $log->setDescription("Ingreso de pedido desde '".$entity->getChannel()."'");
                $log->setResource("order_number_".$entity->getId());
                $log->setIcon('mdi mdi-login-variant');
                $log->setStatus('success');
                $log->setUser(null);
                $em->persist($log);
                $em->flush();

                // $this->get('ApiCall')->post($this->generateUrl('api_logs_post',[],UrlGenerator::ABSOLUTE_URL),
                //     [
                //         "title"=>"Nuevo pedido",
                //         "description"=> "Ingreso de pedido desde '".$entity->getChannel()."'",
                //         "resource"=>"order_number_".$entity->getId(),
                //         "icon"=>"mdi mdi-login-variant",
                //         "status"=>"success",
                //         "user"=>null
                //     ]
                // );
                $this->calcTotal($entity);

                return $this->handleView($this->view($entity, Response::HTTP_OK));
            }
            return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
        }catch (Exception $excepcion) {
            return $this->handleView($this->view($this->structureError($excepcion->getMessage()), Response::HTTP_BAD_REQUEST));
        }
    }

    private function structureError($message=null){
        return array(
            'form'=>array(
                'code'=>400,
                'message'=>'Validation Failed',
                'errors'=>array(
                    'children'=>array(
                        'items'=>[$message]
                    )
                )
            )
        );
    }

    private function calcTotal($order){
        $em = $this->getDoctrine()->getManager();
        $currencies=$em->getRepository(Currency::class)->getAll()->getQuery()->getResult();
        $totals=[];
        foreach ($currencies as $key => $currency) {
            $totals[$currency->getSymbol()]=array('total'=>0,'totalVat'=>0,'currency'=>$currency);
            foreach ($order->getItems() as $key => $item) {
                if($item->getProduct()->getCurrency()->getId()==$currency->getId()){
                    $totals[$currency->getSymbol()]["total"]+=$item->getSubtotal();
                    $totals[$currency->getSymbol()]["totalVat"]+=0;
                }
            }
        }
        foreach ($totals as $key => $total) {
            $ordersTotal=new OrdersTotal();
            $ordersTotal->setCurrency($total["currency"]);
            $ordersTotal->setOrder($order);
            $ordersTotal->setGross($total["total"]);
            $ordersTotal->setTotal($total["total"]);
            $ordersTotal->setVat(0);
            $em->persist($ordersTotal);
        }
        $em->flush();
    }

    public function getAction($id){
        if (!$entity = $this->getDoctrine()->getRepository(Orders::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));

        return $this->handleView($this->view($entity));
    }
    
    public function logsAction($id){
        $entities = $this->getDoctrine()->getRepository(Log::class)->findByResource("order_number_${id}",array('createdAt'=>'DESC'));
        return $this->handleView($this->view($entities));
    }
    
    public function deleteAction(Request $request, $id)
    {
        if (!$entity = $this->getDoctrine()->getRepository(Orders::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));

        $form = $this->createFormBuilder(null, array('csrf_protection' => false))->setMethod('DELETE')->getForm();
        $form->submit(json_decode($request->getContent(), true));
        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setIsDelete(true);
            $this->getDoctrine()->getManager()->flush();
            return $this->handleView($this->view($entity, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form->getErrors(), Response::HTTP_BAD_REQUEST));
    }

    public function changeOrderAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        if(!$entity=$em->getRepository(Orders::class)->find($id))
            return $this->handleView($this->view(null, Response::HTTP_NOT_FOUND));
        $content=json_decode($request->getContent(), true);
        if(!$entityStatus=$em->getRepository(OrdersStatus::class)->find($content["status"]))
            return $this->handleView($this->view(array('message'=>'Ocurrió un error inesperado'), Response::HTTP_NOT_FOUND));
        if($entity->getStatus()==$entityStatus)
            return $this->handleView($this->view(array('message'=>'Debe seleccionar un estado diferente'), Response::HTTP_BAD_REQUEST));
        $oldStatusName=$entity->getStatus()->getName();

        $log = new Log();
        $log->setTitle("De '".$oldStatusName."' a '".$entityStatus->getName()."'");
        $log->setDescription($content["comment"]);
        $log->setResource("order_number_".$entity->getId());
        $log->setIcon('mdi mdi-alert-circle');
        $log->setStatus($entityStatus->getColor());
        $log->setUser($content["user"]);
        $em->persist($log);
        
        $entity->setStatus($entityStatus);
        $em->persist($entity);
        $em->flush();
        if($content["notify"]){
            if($entity->getCustomerId()->getToken()){
                /** Generar notificacion */
                $result=$this->get('FirebaseNotifications')->push(
                    [
                        "notification"=>array("title"=>"Cambios en tu pedido #".$entity->getId(),"body"=>"Tu pedido cambió de estado '".$oldStatusName."' a '".$entityStatus->getName()."'"),
                        "to"=> $entity->getCustomerId()->getToken()
                    ]);
                /** Fin Generar notificacion */
            }
            /** Enviar email */
            $settings = $this->container->get('setting');
            $message = (new \Swift_Message($this->get('setting')->getData()->getTitle().' - Cambios en tu pedido #'.$entity->getId()))
            ->setFrom(array($this->getParameter('mailer_user')=>$this->get('setting')->getData()->getTitle()))
            ->setTo($entity->getCustomerId()->getEmail())
            ->setBody($this->renderView('InamikaBackOfficeBundle:Emails:Orders/changeStatus.html.twig', array('entity' => $entity,'status'=>$oldStatusName)),'text/html');
            $this->get('mailer')->send($message);
            /** Fin enviar email */
        }

        return $this->handleView($this->view($entityStatus, Response::HTTP_OK));
    }
}
