<?php

namespace Service\Order;


use Model\Entity\Product;
use Service\Billing\IBilling;
use Service\Communication\ICommunication;
use Service\Discount\IDiscount;
use Service\User\ISecurity;

class BasketBuilder
{
    /**
     * @var IDiscount
     */
    protected $discount;
    /**
     * @var IBilling
     */
    protected $billing;
    /**
     * @var ISecurity
     */
    protected $security;
    /**
     * @var ICommunication
     */
    protected $communication;

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param Product[] $products
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    /**
     * @var Product[]
     */
    protected $products;

    /**
     * @return IDiscount
     */
    public function getDiscount(): IDiscount
    {
        return $this->discount;
    }

    /**
     * @param IDiscount $discount
     */
    public function setDiscount(IDiscount $discount): void
    {
        $this->discount = $discount;
    }

    /**
     * @return IBilling
     */
    public function getBilling(): IBilling
    {
        return $this->billing;
    }

    /**
     * @param IBilling $billing
     */
    public function setBilling(IBilling $billing): void
    {
        $this->billing = $billing;
    }

    /**
     * @return ISecurity
     */
    public function getSecurity(): ISecurity
    {
        return $this->security;
    }

    /**
     * @param ISecurity $security
     */
    public function setSecurity(ISecurity $security): void
    {
        $this->security = $security;
    }

    /**
     * @return ICommunication
     */
    public function getCommunication(): ICommunication
    {
        return $this->communication;
    }

    /**
     * @param ICommunication $communication
     */
    public function setCommunication(ICommunication $communication): void
    {
        $this->communication = $communication;
    }

    public function build()
    {
        $totalPrice = 0;
        foreach ($this->products as $product) {
            $totalPrice += $product->getPrice();
        }

        $discount = $this->discount->getDiscount();
        $totalPrice = $totalPrice - $totalPrice / 100 * $discount;

        $this->billing->pay($totalPrice);

        $user = $this->security->getUser();
        $this->communication->process($user, 'checkout_template');
    }

}