<?php

namespace Ecommerce\PaymentBundle\Entity;

use Ecommerce\FrontendBundle\Entity\CustomEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class PaymentRepository extends CustomEntityRepository
{
    protected $specialFields = array();

    public function findPaymentsByMonth($date, $limit = null)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p');

        if (is_string($date)) {
            $date = new \DateTime($date);
        }

        $dateFrom = $date;
        $dateTo = $date;
        $dateFrom->modify('first day of this month');
        $dateTo->modify('last day of this month');
ldd($dateFrom, $dateTo);
        $qb->addOrderBy('p.created','ASC');

        $and = $qb->expr()->andx();

        $and->add($qb->expr()->gte('p.created', '\''.$date->format('Y-m-d H:i:s').'\''));

        $qb->andWhere($and);

        if (isset($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    public function findNotShipment($limit = 1)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('s');

        $qb->addOrderBy('s.cost','ASC');

        $and = $qb->expr()->andx();

        $and->add($qb->expr()->eq('s.cost', '0.0'));

        $qb->andWhere($and);

        if (isset($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }
}
