<?php

namespace App\Command;

use App\Entity\Customer;
use App\Service\CustomerManagerInterface;
use App\Service\PhoneValidatorInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ValidatePhonesCommand extends Command
{
    protected static $defaultName = 'app:patch:validate-phones';
    protected static $defaultDescription = 'Patch Validate The Users Phones and Set the Country Codes';

    /** @var CustomerManagerInterface */
    private $customerManager;

    /** @var PhoneValidatorInterface */
    private $phoneValidator;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param string|null $name
     * @param CustomerManagerInterface $customerManager
     * @param PhoneValidatorInterface $phoneValidator
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        string $name = null,
        CustomerManagerInterface $customerManager,
        PhoneValidatorInterface $phoneValidator,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($name);
        $this->phoneValidator = $phoneValidator;
        $this->customerManager = $customerManager;
        $this->entityManager = $entityManager;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $batchSize = 20;
        $iteration = 1;
        $query = $this->getCustomerRepository()->createQueryBuilder('customer')->getQuery();

        /** @var Customer $customer */
        foreach ($query->toIterable() as $customer) {
            $country = $this->customerManager->getCounty($customer->getPhone());

            if (!$country) {
                continue;
            }
            $customer->setCountryCode($country->getCode());
            $customer->setHasValidPhone($this->phoneValidator->valid($customer->getPhone(), $country->getRegex()));
            $this->entityManager->persist($customer);
            ++$iteration;
            if (($iteration % $batchSize) === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
        }
        $this->entityManager->flush();

        $io->success('DONE');

        return Command::SUCCESS;
    }

    /**
     * @return ServiceEntityRepositoryInterface
     */
    private function getCustomerRepository(): ServiceEntityRepositoryInterface
    {
        return $this->entityManager->getRepository(Customer::class);
    }
}
