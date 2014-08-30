<?php namespace PhilipBrown\Merchant;

class ImmutableProduct
{
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
     * @var Money
     */
    private $delivery;

    /**
     * @var Quantity
     */
    private $quantity;

    /**
     * @var Status
     */
    private $freebie;

    /**
     * @var Status
     */
    private $taxable;

    /**
     * @var Collection
     */
    private $coupons;

    /**
     * @var Collection
     */
    private $tags;

    /**
     * @var array
     */
    private $discount;

    /**
     * Create a new ImmutableProduct
     *
     * @param Product $product
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->discount     = $this->applyDiscount($product);

        $this->sku          = $product->sku;
        $this->name         = $product->name;
        $this->price        = $product->price;
        $this->rate         = $product->rate;
        $this->delivery     = $product->delivery;
        $this->quantity     = $product->quantity;
        $this->freebie      = $product->freebie;
        $this->taxable      = $product->taxable;
        $this->coupons      = $product->coupons;
        $this->tags         = $product->tags;
    }

    /**
     * Apply the discount
     *
     * @param Product $product
     * @return mixed
     */
    private function applyDiscount(Product $product)
    {
        if ($product->discount) {
            return $product->discount->calculate($product);
        }
    }

    /**
    * Get the private attributes
    *
    * @param string $key
    * @return mixed
    */
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }
    }
}
