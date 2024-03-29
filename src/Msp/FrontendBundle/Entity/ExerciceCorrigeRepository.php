<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ExerciceCorrigeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExerciceCorrigeRepository extends EntityRepository
{
    public function getTotal()
    {
        $qb = $this->createQueryBuilder('a')->select('COUNT(a)'); 
        return (int) $qb->getQuery()->getSingleScalarResult();
    }
    
    public function getTotalForNiveau( $niveau )
    {       
        $qb =   $this->createQueryBuilder('a')->select('COUNT(a)')
                ->innerJoin('a.chapitre', 'c')                
                ->where('c.niveau = :niveau')                
                ->setParameter( 'niveau', $niveau )                ;
        
        return (int) $qb->getQuery()->getSingleScalarResult();;
    }
    
    public function getByNiveau( $niveau, $limit, $offset )
    {       
        $qb =   $this->createQueryBuilder('a')
                ->innerJoin('a.chapitre', 'c')
                ->where('c.niveau = :niveau')
                ->setParameter( 'niveau', $niveau );
        
        return $qb->getQuery()->setMaxResults($limit)->setFirstResult($offset)->getResult();
    }
}
