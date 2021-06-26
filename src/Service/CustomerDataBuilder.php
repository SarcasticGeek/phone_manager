<?php

namespace App\Service;

use App\Entity\Country;
use App\Entity\Customer as CustomerEntity;
use App\Model\Customer as CustomerModel;

class CustomerDataBuilder implements CustomerDataBuilderInterface
{
    /**
     * @var PhoneValidatorInterface
     */
    private $phoneValidator;

    /**
     * @param PhoneValidatorInterface $phoneValidator
     */
    public function __construct(PhoneValidatorInterface $phoneValidator)
    {
        $this->phoneValidator = $phoneValidator;
    }

    /**
     * @param CustomerEntity $customer
     * @param Country|null $country
     * @return CustomerModel
     */
    public function build(CustomerEntity $customer, ?Country $country): CustomerModel
    {
        $customerData = new CustomerModel();

        $customerData->setCountryCode($country->getCode());
        $customerData->setId($customer->getId());
        $customerData->setName($customer->getName());
        $customerData->setCountry($country->getName());
        $customerData->setPhone($customer->getPhone());
        $customerData->setState(
            $this->getPhoneValidator()->valid($customer->getPhone(), $country->getRegex())
        );

        return $customerData;
    }

    /**
     * @return PhoneValidatorInterface
     */
    public function getPhoneValidator(): PhoneValidatorInterface
    {
        return $this->phoneValidator;
    }


}
