<?php

namespace App\Service;

use App\Constant\PaginationConstant;
use App\Entity\Country;
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

    /**
     * @var CustomerDataBuilderInterface
     */
    private $customerDataBuilder;

    /**
     * @param PaginatorInterface $paginator
     * @param EntityManagerInterface $entityManager
     * @param CustomerDataBuilderInterface $customerDataBuilder
     */
    public function __construct(PaginatorInterface $paginator, EntityManagerInterface $entityManager, CustomerDataBuilderInterface $customerDataBuilder)
    {
        $this->paginator = $paginator;
        $this->entityManager = $entityManager;
        $this->customerDataBuilder = $customerDataBuilder;
    }

    /**
     * @param array $filters
     * @param int $page
     * @param int $limit
     * @return PaginationInterface
     */
    public function list(array $filters, int $page = PaginationConstant::DEFAULT_PAGE, int $limit = PaginationConstant::DEFAULT_LIMIT): PaginationInterface
    {
        $paginatedCustomers = $this->paginator->paginate(
            $this->entityManager->getRepository(Customer::class)->list($filters),
            $page,
            $limit
        );

        return $this->buildPaginatedCustomers($paginatedCustomers);
    }

    /**
     * @param $paginatedCustomers
     * @return PaginationInterface
     */
    private function buildPaginatedCustomers($paginatedCustomers): PaginationInterface
    {
        $builtPaginatedCustomers = [];

        /** @var Customer $customer */
        foreach ($paginatedCustomers->getItems() as $customer) {
            $builtPaginatedCustomers []= $this->customerDataBuilder->build($customer, $this->getCounty($customer->getPhone()));
        }

        $paginatedCustomers->setItems($builtPaginatedCustomers);

        return $paginatedCustomers;
    }

    /**
     * @param string $phoneNumber
     *
     * @return Country|null
     */
    public function getCounty(string $phoneNumber): ?Country
    {
        $code =  preg_match('~(\K\d+)~', $phoneNumber, $out) ? $out[0] : null;

        if (!$code) {
            return null;
        }
        return $this->entityManager->getRepository(Country::class)->findOneBy([
            'code' => $code,
        ]);
    }
}
