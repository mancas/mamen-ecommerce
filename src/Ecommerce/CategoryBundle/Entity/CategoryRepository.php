<?php

namespace Ecommerce\CategoryBundle\Entity;

use Ecommerce\FrontendBundle\Entity\CustomEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class CategoryRepository extends CustomEntityRepository
{
    protected $specialFields = array();

    public function findCategoriesDQL($limit = null)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('c','s');

        $qb->leftJoin('c.subcategories', 's');
        $qb->addOrderBy('c.name','ASC');

        if (isset($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }
}
