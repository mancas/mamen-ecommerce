<?php

namespace Ecommerce\ItemBundle\Entity;

use Ecommerce\FrontendBundle\Entity\CustomEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class ShipmentRepository extends CustomEntityRepository
{
    protected $specialFields = array();

    public function findAllShipmentOptions($limit = null)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('s');

        $qb->addOrderBy('s.cost','ASC');

        $and = $qb->expr()->andx();

        $and->add($qb->expr()->neq('s.cost', '0.0'));

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
