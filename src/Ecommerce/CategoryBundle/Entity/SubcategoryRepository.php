<?php

namespace Ecommerce\CategoryBundle\Entity;

use Ecommerce\FrontendBundle\Entity\CustomEntityRepository;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class SubcategoryRepository extends CustomEntityRepository
{
    protected $specialFields = array();
}
