<?php

namespace App\Service;

use App\Entity\Country;
use App\Entity\Customer as CustomerEntity;
use App\Model\Customer as CustomerModel;

interface CustomerDataBuilderInterface
{
    /**
     * @param CustomerEntity $customer
     * @param Country|null $country
     * @return CustomerModel
     */
    public function build(CustomerEntity $customer, ?Country $country): CustomerModel;
}
