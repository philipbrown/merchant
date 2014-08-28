<?php namespace PhilipBrown\Merchant;

use Money\Money;

class Product
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
     * @var Discount
     */
    private $discount;

    /**
     * @var Category
     */
    private $category;

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
        $this->delivery = new Money(0, $price->getCurrency());
        $this->quantity = Quantity::set(1);
        $this->freebie  = Status::set(false);
        $this->taxable  = Status::set(true);
        $this->coupons  = new Collection;
        $this->tags     = new Collection;
    }

    /**
     * Set the quantity
     *
     * @param Quantity $quantity
     * @return void
     */
    public function quantity(Quantity $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Increment the quantity
     *
     * @return void
     */
    public function increment()
    {
        $this->quantity = $this->quantity->increment();
    }

    /**
     * Decrement the quantity
     *
     * @return void
     */
    public function decrement()
    {
        $this->quantity = $this->quantity->decrement();
    }

    /**
     * Set the freebie status
     *
     * @param Status $status
     * @return void
     */
    public function freebie(Status $status)
    {
        $this->freebie = $status;
    }

    /**
     * Set the taxable status
     *
     * @param Status $status
     * @return void
     */
    public function taxable(Status $status)
    {
        $this->taxable = $status;
    }

    /**
     * Set the delivery charge
     *
     * @param Money $cost
     * @return void
     */
    public function delivery(Money $cost)
    {
        $this->delivery = $cost;
    }

    /**
     * Add a coupon
     *
     * @param String $coupon
     * @return void
     */
    public function addCoupon(String $coupon)
    {
        $this->coupons->push($coupon);
    }

    /**
     * Remove a coupon
     *
     * @param String $coupon
     * @return void
     */
    public function removeCoupon(String $coupon)
    {
        $this->coupons = $this->coupons->filter(function ($item)  use ($coupon) {
            return $item->value() !== $coupon->value();
        });
    }

    /**
     * Add a tag
     *
     * @param String $tag
     * @return void
     */
    public function addTag(String $tag)
    {
        $this->tags->push($tag);
    }

    /**
     * Remove a tag
     *
     * @param String $tag
     * @return void
     */
    public function removeTag(String $tag)
    {
        $this->tags = $this->tags->filter(function ($item) use ($tag) {
            return $item->value() !== $tag->value();
        });
    }

    /**
     * Set a tax rate
     *
     * @param TaxRate $rate
     * @return void
     */
    public function rate(TaxRate $rate)
    {
        $this->rate = $rate;
    }

    /**
     * Set a discount
     *
     * @param Discount $discount
     * @return void
     */
    public function discount(Discount $discount)
    {
        $this->discount = $discount;
    }

    /**
     * Set a category
     *
     * @param Category $category
     * @return void
     */
    public function category(Category $category)
    {
        $this->category = $category;
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
