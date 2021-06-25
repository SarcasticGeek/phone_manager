<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function list(array $filters): Query
    {
        $queryBuilder = $this->createQueryBuilder('customer');

        foreach ($filters as $key => $value) {
            if (method_exists($this, 'filterBy'.ucfirst($key))) {
                $this->{'filterBy'.ucfirst($key)}($queryBuilder, $value);
            }
        }

        return $queryBuilder->getQuery();
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $value
     * @return QueryBuilder
     */
    private function filterByCountryCode(QueryBuilder $queryBuilder , $value): QueryBuilder
    {
        return $queryBuilder->andWhere($queryBuilder->expr()->eq('customer.countryCode', $value));
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $value
     * @return QueryBuilder
     */
    private function filterByHasValidPhone(QueryBuilder $queryBuilder , $value): QueryBuilder
    {
        return $queryBuilder->andWhere($queryBuilder->expr()->eq('customer.hasValidPhone', $value));
    }
}
