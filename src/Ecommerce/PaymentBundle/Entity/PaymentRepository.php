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

    public function findPaymentsDQL($limit = null)
    {
        return $this->findPaymentsDQLPaginate($limit)->getResult();
    }

    public function findPaymentsDQLPaginate($limit = null)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p');

        $qb->addOrderBy('p.created','DESC');

        if (isset($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery();
    }

    public function findPaymentsByMonth($date, $limit = null)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p');

        if (!is_string($date)) {
            $date = $date->format('y-m-d');
        }

        $dateFrom = new \DateTime($date);
        $dateTo = new \DateTime($date);
        $dateFrom->modify('first day of this month');
        $dateTo->modify('last day of this month');

        $qb->addOrderBy('p.created','ASC');

        $and = $qb->expr()->andx();

        $and->add($qb->expr()->gte('p.created', '\''.$dateFrom->format('Y-m-d H:i:s').'\''));
        $and->add($qb->expr()->lte('p.created', '\''.$dateTo->format('Y-m-d H:i:s').'\''));

        $qb->andWhere($and);

        if (isset($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }
}
