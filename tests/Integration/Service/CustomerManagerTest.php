<?php

namespace App\Tests\Integration\Service;

use App\Service\CustomerManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CustomerManagerTest extends KernelTestCase
{
    public function testList()
    {
        self::bootKernel();

        $container = self::$container;

        $customerManager = $container->get(CustomerManagerInterface::class);

        $this->assertInstanceOf(PaginationInterface::class, $customerManager->list([], 1, 1));
    }
}
