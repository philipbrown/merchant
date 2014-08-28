<?php namespace PhilipBrown\Merchant;

use Money\Money;

class Product {

    /**
     * @var SKU
     */
    private $sku;

    /**
     * @var Name
     */
    private $name;

    /**
     * @var Money
     */
    private $price;

    /**
     * @var TaxRate
     */
    private $rate;

    /**
     * Create a new Product
     *
     * @param SKU $sku
     * @param Name $name
     * @param Money $price
     * @param TaxRate $rate
     * @return void
     */
    public function __construct(SKU $sku, Name $name, Money $price, TaxRate $rate)
    {
        $this->sku      = $sku;
        $this->name     = $name;
        $this->price    = $price;
        $this->rate     = $rate;
    }

}
