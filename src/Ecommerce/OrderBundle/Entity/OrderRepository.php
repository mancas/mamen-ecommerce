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

    public function findOrdersResume($limit = null)
    {
        $dateFrom = new \DateTime('now');
        $dateTo = new \DateTime('now');
        $dateFrom->modify('-7 days');

        $qb = $this->createQueryBuilder('o');
        $qb->select('COUNT(o) as TotalOrders, o.date');
        $qb->addOrderBy('o.date', 'ASC');
        $qb->addGroupBy('o.date');

        $and = $qb->expr()->andx();
        $and->add($qb->expr()->gte('o.date', '\''.$dateFrom->format('Y-m-d H:i:s').'\''));
        $and->add($qb->expr()->lte('o.date', '\''.$dateTo->format('Y-m-d H:i:s').'\''));

        $qb->where($and);

        if (isset($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }
}
