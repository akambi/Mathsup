<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TicketRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TicketRepository extends EntityRepository
{
    public function getTotal()
    {
        $qb = $this->createQueryBuilder('a')->select('COUNT(a)'); 
        return (int) $qb->getQuery()->getSingleScalarResult();
    } 
    
    public function getAllForUser( $user, $date )
    {
        $qb =   $this->createQueryBuilder('a')
                ->where('a.user = :user')
                ->setParameter('user', $user)
                ->andWhere('a.date >= :date')
                ->setParameter('date', $date);
    
        return $qb->getQuery()->getResult();
    }
}
