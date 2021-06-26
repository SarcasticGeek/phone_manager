<?php

namespace App\Tests\Service;

use App\Entity\Country;
use App\Repository\CountryRepository;
use App\Repository\CustomerRepository;
use App\Service\CustomerManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;
use Mockery;

class CustomerManagerTest extends TestCase
{

    public function testList()
    {
        $repository = Mockery::mock(CustomerRepository::class)
            ->makePartial()
            ->shouldReceive('list')
            ->once()
            ->andReturnUsing(function () {
                return new Query();
            })
            ->getMock()
        ;

        $paginator = Mockery::mock(PaginatorInterface::class)
            ->makePartial()
            ->shouldReceive([
                'getCustomerRepository' => $repository
            ])
            ->once()
            ->andReturnUsing(function () {
                return new SlidingPagination();
            })
            ->getMock()
        ;

        $customerManager = Mockery::mock(CustomerManager::class)
            ->makePartial()
            ->shouldReceive([
                'getPaginator' => $paginator
            ])
            ->once()
            ->getMock()
        ;

        $this->assertInstanceOf(PaginationInterface::class, $customerManager->list([], 1, 1));
    }

    public function testGetCounty()
    {
        $phoneNumber = "(212) 698054317";

        $repository = Mockery::mock(CountryRepository::class)
            ->makePartial()
            ->shouldReceive('findOneBy')
            ->once()
            ->andReturnUsing(function () {
                return new Country();
            })
            ->getMock()
        ;

        $customerManager = Mockery::mock(CustomerManager::class)
            ->makePartial()
            ->shouldReceive([
                'getCountryRepository' => $repository
            ])
            ->once()
            ->getMock()
        ;

        $this->assertInstanceOf(Country::class, $customerManager->getCounty($phoneNumber));
    }

    public function testExtractPhoneCode()
    {
        $phoneNumber = "(212) 698054317";

        $customerManager = Mockery::mock(CustomerManager::class)
            ->makePartial()
            ->shouldReceive()
            ->once()
            ->getMock()
        ;

        $this->assertEquals("212", $customerManager->extractPhoneCode($phoneNumber));
    }
}
