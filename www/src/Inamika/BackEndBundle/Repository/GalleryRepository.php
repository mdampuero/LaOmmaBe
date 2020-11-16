<?php

namespace Inamika\BackEndBundle\Repository;

/**
 * GalleryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GalleryRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAll(){
        return $this->createQueryBuilder('e')
        ->select('e')
        ->where('e.isDelete = :isDelete')
        ->setParameter('isDelete',false)
        ->orderBy("e.id","DESC");
    }
}