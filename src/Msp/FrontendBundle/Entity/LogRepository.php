<?php

namespace Msp\FrontendBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * LogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LogRepository extends EntityRepository
{
    public function getLogs($nombreParPage, $page, $user = null)
    {
    //  On vérifie que la page n'est pas inférieur à 1
        if ($page < 1) {
        throw new \InvalidArgumentException('The argument $page can not be less than one ( value : "'.$page.'" ).');
        }
    //  On recupère la requête
        $query = $this->createQueryBuilder('a');
        if($user):
            $query =    $query->where('a.user = :user')
                        ->setParameter('user', $user);
        endif;
    //  On recupère la requête
        $query->getQuery();
    //  On définit l'address à partir duquel commencer la liste
        $query->setFirstResult( ($page-1) * $nombreParPage )
    //  Ainsi que le nombre d'address à afficher
        ->setMaxResults($nombreParPage);
    //  Enfin, on retourne l'objet Paginator correspondant à la requête construite
        return new Paginator($query);
    }   
}
