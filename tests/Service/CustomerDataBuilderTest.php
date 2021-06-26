<?php

namespace App\Tests\Service;

use App\Entity\Country;
use App\Entity\Customer;
use App\Model\Customer as CustomerModel;
use App\Repository\CountryRepository;
use App\Service\CountryManager;
use App\Service\CustomerDataBuilder;
use App\Service\PhoneValidator;
use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Mockery;

class CustomerDataBuilderTest extends TestCase
{
    public function testBuild()
    {
        $faker = Factory::create();

        $phoneValidator = Mockery::mock(PhoneValidator::class)
            ->makePartial()
            ->shouldReceive('valid')
            ->once()
            ->andReturn(true)
            ->getMock()
        ;

        $customerData = new Customer();

        $customerData->setPhone($faker->phoneNumber);
        $customerData->setName($faker->name);
        $customerData->setCountryCode($faker->countryCode);

        $country = new Country();

        $country->setName($faker->country);
        $country->setCode($faker->countryCode);
        $country->setRegex($faker->regexify());

        $customerDataBuilder = Mockery::mock(CustomerDataBuilder::class)
            ->makePartial()
            ->shouldReceive([
                'getPhoneValidator' => $phoneValidator
            ])
            ->once()
            ->getMock()
        ;

        $this->assertInstanceOf(CustomerModel::class, $customerDataBuilder->build($customerData, $country), );
    }
}
