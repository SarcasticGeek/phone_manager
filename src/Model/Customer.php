<?php

namespace App\Model;

class Customer
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var bool
     */
    private $state;

    /**
     * @var string
     */
    private $phone;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Customer
     */
    public function setId(int $id): Customer
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Customer
     */
    public function setName(string $name): Customer
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return Customer
     */
    public function setCountry(string $country): Customer
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return sprintf('+%s', $this->countryCode);
    }

    /**
     * @param string $countryCode
     * @return Customer
     */
    public function setCountryCode(string $countryCode): Customer
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return bool
     */
    public function isState(): bool
    {
        return $this->state;
    }

    /**
     * @param bool $state
     * @return Customer
     */
    public function setState(bool $state): Customer
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return preg_match('/[0-9]+$/', $this->phone, $out) ? $out[0] : "";
    }

    /**
     * @param string $phone
     * @return Customer
     */
    public function setPhone(string $phone): Customer
    {
        $this->phone = $phone;

        return $this;
    }
}