<?php

namespace App\Tests\Service;

use App\Service\PhoneValidator;
use PHPUnit\Framework\TestCase;
use Mockery;

class PhoneValidatorTest extends TestCase
{
    public function testValid()
    {
        $phoneValidator = Mockery::mock(PhoneValidator::class)
            ->makePartial()
            ->shouldReceive()
            ->once()
            ->getMock()
        ;

        $phoneNumber = "(212) 698054317";
        $regEx = '\(212\)\ ?[5-9]\d{8}$';

        $this->assertEquals(true, $phoneValidator->valid($phoneNumber, $regEx));
    }
}
