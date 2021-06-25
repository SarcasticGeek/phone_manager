<?php

namespace App\Service;

use App\Constant\PaginationConstant;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class CustomerManager implements CustomerManagerInterface
{
    /** @var PaginatorInterface */
    private $paginator;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(PaginatorInterface $paginator, EntityManagerInterface $entityManager)
    {
        $this->paginator = $paginator;
        $this->entityManager = $entityManager;
    }

    public function list(int $page = PaginationConstant::DEFAULT_PAGE, int $limit = PaginationConstant::DEFAULT_LIMIT): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->entityManager->getRepository(Customer::class)->list(),
            $page,
            $limit
        );
    }
}