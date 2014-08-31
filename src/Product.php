<?php namespace PhilipBrown\Merchant;

use Closure;
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
     * @var Object
     */
    private $discount;

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
     * Get the SKU
     *
     * @return SKU
     */
    public function sku()
    {
        return $this->sku;
    }

    /**
     * Get the name
     *
     * @return Name
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get the price
     *
     * @return Money
     */
    public function price()
    {
        return $this->price;
    }

    /**
     * Set the quantity
     *
     * @param Quantity $quantity
     * @return void
     */
    public function setQuantity(Quantity $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Get the quantity
     *
     * @return Quantity
     */
    public function quantity()
    {
        return $this->quantity;
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
    public function setFreebie(Status $status)
    {
        $this->freebie = $status;
    }

    /**
     * Get the freebie status
     *
     * @return Status
     */
    public function freebie()
    {
        return $this->freebie;
    }

    /**
     * Set the taxable status
     *
     * @param Status $status
     * @return void
     */
    public function setTaxable(Status $status)
    {
        $this->taxable = $status;
    }

    /**
     * Get the taxable status
     *
     * @return Status
     */
    public function taxable()
    {
        return $this->taxable;
    }

    /**
     * Set the delivery charge
     *
     * @param Money $cost
     * @return void
     */
    public function setDelivery(Money $cost)
    {
        $this->delivery = $cost;
    }

    /**
     * Get the delivery charge
     *
     * @return Money
     */
    public function delivery()
    {
        return $this->delivery;
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
     * Get the coupons Collection
     *
     * @return Collection
     */
    public function coupons()
    {
        return $this->coupons;
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
     * Get the tags Collection
     *
     * @return Collection
     */
    public function tags()
    {
        return $this->tags;
    }

    /**
     * Set a tax rate
     *
     * @param TaxRate $rate
     * @return void
     */
    public function setRate(TaxRate $rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get the tax rate
     *
     * @return TaxRate
     */
    public function rate()
    {
        return $this->rate;
    }

    /**
     * Set a discount
     *
     * @param Discount $discount
     * @return void
     */
    public function setDiscount(Discount $discount)
    {
        $this->discount = new Object([
            'rate' =>$discount->rate(),
            'value' => $discount->calculate($this)
        ]);
    }

    /**
     * Get the discount
     *
     * @return Object
     */
    public function discount()
    {
        return $this->discount;
    }

    /**
     * Set a category
     *
     * @param Category $category
     * @return void
     */
    public function setCategory(Category $category)
    {
        $category->categorise($this);
    }

    /**
     * Run a Closure of actions
     *
     * @param Closue $actions
     * @return void
     */
    public function action(Closure $actions)
    {
        call_user_func($actions, $this);
    }
}
