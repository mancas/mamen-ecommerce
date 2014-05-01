<?php

namespace Ecommerce\ItemBundle\Entity;

use Ecommerce\FrontendBundle\Entity\CustomEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class ItemRepository extends CustomEntityRepository
{
    protected $specialFields = array('name');

    protected function addToQueryBuilderSpecialFieldName(\Doctrine\ORM\QueryBuilder &$qb, $value)
    {
        $qb->andWhere($qb->expr()->like('i.name', $qb->expr()->literal('%'. $value . '%')));
    }
}
