<?php

namespace App\Service;

use App\Constant\PaginationConstant;
use App\Entity\Country;
use App\Entity\Customer;
use App\Repository\CountryRepository;
use App\Repository\CustomerRepository;
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
    public function list(array $filters = [], int $page = PaginationConstant::DEFAULT_PAGE, int $limit = PaginationConstant::DEFAULT_LIMIT): PaginationInterface
    {
        $paginatedCustomers = $this->getPaginator()->paginate(
            $this->getCustomerRepository()->list($filters),
            $page,
            $limit
        );

        return $this->buildPaginatedCustomers($paginatedCustomers);
    }

    /**
     * @param $paginatedCustomers
     * @return PaginationInterface
     */
    public function buildPaginatedCustomers($paginatedCustomers): PaginationInterface
    {
        $builtPaginatedCustomers = [];

        /** @var Customer $customer */
        foreach ($paginatedCustomers->getItems() as $customer) {
            $builtPaginatedCustomers []= $this->getCustomerDataBuilder()
                ->build($customer, $this->getCounty($customer->getPhone()));
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
        $code = $this->extractPhoneCode($phoneNumber);

        if (!$code) {
            return null;
        }
        return $this->getCountryRepository()->findOneBy([
            'code' => $code,
        ]);
    }

    /**
     * @return CustomerRepository
     */
    public function getCustomerRepository(): CustomerRepository
    {
        return $this->getEntityManager()->getRepository(Customer::class);
    }

    /**
     * @return CountryRepository
     */
    public function getCountryRepository(): CountryRepository
    {
        return $this->getEntityManager()->getRepository(Country::class);
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @return PaginatorInterface
     */
    public function getPaginator(): PaginatorInterface
    {
        return $this->paginator;
    }

    /**
     * @return CustomerDataBuilderInterface
     */
    public function getCustomerDataBuilder(): CustomerDataBuilderInterface
    {
        return $this->customerDataBuilder;
    }

    /**
     * @param string $phoneNumber
     *
     * @return string|null
     */
    public function extractPhoneCode(string $phoneNumber): ?string
    {
        return preg_match('~(\K\d+)~', $phoneNumber, $out) ? $out[0] : null;
    }
}
