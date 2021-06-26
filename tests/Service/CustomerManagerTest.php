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
