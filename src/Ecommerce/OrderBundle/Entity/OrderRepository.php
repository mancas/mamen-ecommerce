<?php

namespace Ecommerce\OrderBundle\Entity;

use Ecommerce\FrontendBundle\Entity\CustomEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class OrderRepository extends CustomEntityRepository
{
    protected $specialFields = array();

    public function findOrdersByUserEmail($userEmail, $limit = null)
    {
        $qb = $this->createQueryBuilder('o');
        $qb->select('o.id');

        //$qb->leftJoin('o.customer', 'u');
        //$qb->addOrderBy('o.date','DESC');

        $and = $qb->expr()->andx();

        //$and->add($qb->expr()->eq('u.email', '\''. $userEmail .'\''));

        //$qb->where($and);

        if (isset($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }
}
