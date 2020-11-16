<?php

namespace Inamika\BackEndBundle\Repository;
use Inamika\BackEndBundle\Entity\Project;
use Inamika\BackEndBundle\Entity\Customer;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * CustomerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CustomerRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAll(){
        return $this->createQueryBuilder('e')
        ->select('e')
        ->where('e.isDelete = :isDelete')
        ->setParameter('isDelete',false)
        ->orderBy("e.id","DESC");
    }
    
    public function import($file){
        if (($handle = fopen($file, "r")) !== FALSE) {
            $em = $this->getEntityManager();
            $i=0;
            while (($data = fgetcsv($handle, null, ';')) !== FALSE) {
                $data = array_map("utf8_encode", $data);
                $i++;
                if ($i<=1) continue;
                
                
            }
            fclose($handle);
            $em->flush();
        }

        return ;
    }

    public function search($query=null,$limit=0,$offset=0,$sort=null,$direction=null){
        if($limit>100) $limit=100;
        if($limit==0) $limit=30;
        $qb= $this->getAll()
        ->setFirstResult($offset)
        ->setMaxResults($limit);
        if($sort){
            if(strpos($sort, ".") === false)
                $sort='e.'.$sort;
            $qb->orderBy($sort,$direction);
        }else{
            $qb->orderBy("e.createdAt","DESC");
            // $qb->orderBy('RAND('.$direction.')');
        }
        if($query){
            $words=explode(" ",$query);
            if(count($words)>1){
                foreach ($words as $key => $word) {
                    $queryString=array();
                    $queryString[]="CONCAT(COALESCE(e.name,''),COALESCE(e.document,''),COALESCE(e.email,'')) LIKE :word".$key;
                    $qb->setParameter('word'.$key,"%".$word."%");
                    $qb->andWhere(join(' AND ',$queryString));
                }
            }else{
                $qb->andWhere("CONCAT(COALESCE(e.name,''),COALESCE(e.document,''),COALESCE(e.email,'')) LIKE :query")->setParameter('query',"%".$query."%");
            }
        }
        return $qb;
    }

    public function searchTotal($query=null,$limit=0,$offset=0){
        $resultTotal=$this->search($query,$limit=0,$offset=0)
        ->setFirstResult(null)
        ->select('COUNT(e.id) as total')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
        return (int)$resultTotal['total'];
    }
   
    public function total(){
        $resultTotal=$this->search()
        ->setFirstResult(null)
        ->where('e.isDelete = :isDelete')
        ->setParameter('isDelete',false)
        ->select('COUNT(e.id) as total')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
        return (int)$resultTotal['total'];
    }


    public function getUniqueNotDeleted(array $parameters){
        return $this->createQueryBuilder('e')
        ->select('e')
        ->where('e.isDelete = :isDelete')
        ->setParameter('isDelete',false)
        ->andWhere('e.email= :email')
        ->setParameter('email',$parameters['email'])
        ->setMaxResults(1)->getQuery()->getResult();
    }
}
