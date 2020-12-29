<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FortuneCookieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FortuneCookieRepository extends EntityRepository
{

    public function countNumberPrintedForCategory(Category $category)
    {
        /**
         * Way to write Raw SQL Queries using Doctrine
         */
        /*
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = '
            SELECT 
                SUM(dc.numberPrinted) as fortunesPrinted, 
                AVG(fc.numberPrinted) as fortunesAverage
            FROM fortune_cookie fc
            INNER JOIN category cat ON cat.id = fc.category_id
            WHERE fc.category_id = :category
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['category' =>$category->getId()]);
        $stmt->fetchAll();
        */

        return $this->createQueryBuilder('fc')
            ->andWhere('fc.category = :category')
            ->setParameter('category', $category)
            ->innerJoin('fc.category', 'cat')
            ->select('SUM(fc.numberPrinted) as fortunesPrinted')
            ->addSelect('AVG(fc.numberPrinted) as fortunesAverage')
            ->addSelect('cat.name')
            ->getQuery()
            ->getOneOrNullResult();
    }
}
