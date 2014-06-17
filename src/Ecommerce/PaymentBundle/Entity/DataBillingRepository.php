<?php

namespace Ecommerce\PaymentBundle\Entity;

use Ecommerce\FrontendBundle\Entity\CustomEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class DataBillingRepository extends CustomEntityRepository
{
    public function findBusinessDataBilling()
    {
        $qb = $this->createQueryBuilder('d');
        $qb->select('d');

        $qb->leftJoin('d.address', 'a');

        $and = $qb->expr()->andx();

        $and->add($qb->expr()->isNull('a.user'));

        $qb->where($and);

        return $qb->getQuery()->getResult();
    }
}