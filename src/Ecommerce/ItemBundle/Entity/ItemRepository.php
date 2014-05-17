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

    public function findRecentItemsDQL($limit = null)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p','i');

        $qb->leftJoin('p.images', 'i');
        $qb->addOrderBy('p.updated','DESC');

        if (isset($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    public function findCategorySEOItemsDQL($category, $limit = null)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p','i', 's', 'c');

        $qb->leftJoin('p.images', 'i');
        $qb->leftJoin('p.subcategory', 's');
        $qb->leftJoin('s.category', 'c');
        $qb->addOrderBy('p.updated','ASC');

        $and = $qb->expr()->andx();

        $and->add($qb->expr()->eq('c.slug', '\''. $category->getSlug() .'\''));

        $qb->where($and);

        if (isset($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    public function findRelatedItems($item, $limit = null)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p','i', 's');

        $qb->leftJoin('p.images', 'i');
        $qb->leftJoin('p.subcategory', 's');
        $qb->addOrderBy('p.updated','DESC');

        $and = $qb->expr()->andx();

        $and->add($qb->expr()->neq('p.slug', "'" . $item->getSlug() . "'"));
        $and->add($qb->expr()->eq('s.slug', "'" . $item->getSubcategory()->getSlug() . "'"));

        $qb->where($and);

        if (isset($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }

    public function findItemsBySubcategoryDQL($subcategory, $limit = null)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->select('p','i', 's');

        $qb->leftJoin('p.images', 'i');
        $qb->leftJoin('p.subcategory', 's');
        $qb->addOrderBy('p.updated','DESC');

        $and = $qb->expr()->andx();

        $and->add($qb->expr()->eq('s.slug', "'" . $subcategory->getSlug() . "'"));

        $qb->where($and);

        if (isset($limit)) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery();
    }
}
