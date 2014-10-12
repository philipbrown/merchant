<?php namespace PhilipBrown\Merchant\Fixtures;

use PhilipBrown\Merchant\Basket;
use PhilipBrown\Merchant\Jurisdictions\UnitedKingdom;

class BasketFixture implements Fixture
{
    /**
     * @var ProductFixture
     */
    private $products;

    /**
     * Create a new BasketFixture
     *
     * @return void
     */
    public function __construct()
    {
        $this->products = new ProductFixture;
    }

    /**
     * Load the fixtures
     *
     * @return array
     */
    public function load(){}

    /**
     * Product 0
     *
     * Value:    £10.00
     * Delivery: £0
     * Total:    £12.00
     *
     * @return Basket
     */
    public function zero()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductZero($basket);

        return $basket;
    }

    /**
     * Products 1 + 2
     *
     * Value:    £314.97
     * Delivery: £0
     * Total:    £374.96
     *
     * @return Basket
     */
    public function one()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductOne($basket);
        $basket = $this->addProductTwo($basket);

        return $basket;
    }

    /**
     * Products 3 + 4
     *
     * Value:    £1,004.98
     * Delivery: £0
     * Total:    £1,079.99
     *
     * @return Basket
     */
    public function two()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductThree($basket);
        $basket = $this->addProductFour($basket);

        return $basket;
    }

    /**
     * Products 4 + 5 + 6
     *
     * Value:    £1,949.48
     * Delivery: £60.00
     * Total:    £2,261.38
     *
     * @return Basket
     */
    public function three()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductFour($basket);
        $basket = $this->addProductFive($basket);
        $basket = $this->addProductSix($basket);

        return $basket;
    }

    /**
     * Products 7 + 8
     *
     * Value:    £211.94
     * Delivery: £39.94
     * Total:    £262.43
     *
     * @return Basket
     */
    public function four()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductSeven($basket);
        $basket = $this->addProductEight($basket);

        return $basket;
    }

    /**
     * Products 1 + 4 + 9
     *
     * Value:    £1,089.99
     * Delivery: £2.97
     * Total:    £1,097.96
     *
     * @return Basket
     */
    public function five()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductOne($basket);
        $basket = $this->addProductFour($basket);
        $basket = $this->addProductNine($basket);

        return $basket;
    }

    /**
     * Products 0 + 3 + 7
     *
     * Value:    £146.95
     * Delivery: £27.96
     * Total:    £182.47
     *
     * @return Basket
     */
    public function six()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductZero($basket);
        $basket = $this->addProductThree($basket);
        $basket = $this->addProductSeven($basket);

        return $basket;
    }

    /**
     * Products 5 + 6 + 7
     *
     * Value:    £1,081.45
     * Delivery: £87.96
     * Total:    £1,351.86
     *
     * @return Basket
     */
    public function seven()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductFive($basket);
        $basket = $this->addProductSix($basket);
        $basket = $this->addProductSeven($basket);

        return $basket;
    }

    /**
     * Products 2 + 3 + 4
     *
     * Value:    £1,304.95
     * Delivery: £0
     * Total:    £1,439.95
     *
     * @return Basket
     */
    public function eight()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductTwo($basket);
        $basket = $this->addProductThree($basket);
        $basket = $this->addProductFour($basket);

        return $basket;
    }

    /**
     * Products 0 + 5 + 8 + 9
     *
     * Value:    £214.48
     * Delivery: £14.95
     * Total:    £148.33
     *
     * @return Basket
     */
    public function nine()
    {
        $basket = new Basket(new UnitedKingdom);

        $basket = $this->addProductZero($basket);
        $basket = $this->addProductFive($basket);
        $basket = $this->addProductEight($basket);
        $basket = $this->addProductNine($basket);

        return $basket;
    }

    /**
     * Add Product Zero
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductZero(Basket $basket)
    {
        $zero = $this->products->zero();

        $basket->add($zero->sku, $zero->name, $zero->price);

        return $basket;
    }

    /**
     * Add Product One
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductOne(Basket $basket)
    {
        $one = $this->products->one();

        $basket->add($one->sku, $one->name, $one->price, function ($product) use ($one) {
            $product->category($one->category);
        });

        return $basket;
    }

    /**
     * Add Product Two
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductTwo(Basket $basket)
    {
        $two = $this->products->two();

        $basket->add($two->sku, $two->name, $two->price, function ($product) use ($two) {
            $product->quantity($two->quantity);
        });

        return $basket;
    }

    /**
     * Add Product Three
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductThree(Basket $basket)
    {
        $three = $this->products->three();

        $basket->add($three->sku, $three->name, $three->price, function ($product) use ($three) {
            $product->freebie($three->freebie);
        });

        return $basket;
    }

    /**
     * Add Product Four
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductFour(Basket $basket)
    {
        $four = $this->products->four();

        $basket->add($four->sku, $four->name, $four->price, function ($product) use ($four) {
            $product->discount($four->discount);
        });

        return $basket;
    }

    /**
     * Add Product Five
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductFive(Basket $basket)
    {
        $five = $this->products->five();

        $basket->add($five->sku, $five->name, $five->price, function ($product) use ($five) {
            $product->discount($five->discount);
        });

        return $basket;
    }

    /**
     * Add Product Six
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductSix(Basket $basket)
    {
        $six = $this->products->six();

        $basket->add($six->sku, $six->name, $six->price, function ($product) use ($six) {
            $product->delivery($six->delivery);
        });

        return $basket;
    }

    /**
     * Add Product Seven
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductSeven(Basket $basket)
    {
        $seven = $this->products->seven();

        $basket->add($seven->sku, $seven->name, $seven->price, function ($product) use ($seven) {
            $product->quantity($seven->quantity);
            $product->discount($seven->discount);
            $product->delivery($seven->delivery);
        });

        return $basket;
    }

    /**
     * Add Product Eight
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductEight(Basket $basket)
    {
        $eight = $this->products->eight();

        $basket->add($eight->sku, $eight->name, $eight->price, function ($product) use ($eight) {
            $product->quantity($eight->quantity);
            $product->taxable($eight->taxable);
            $product->delivery($eight->delivery);
        });

        return $basket;
    }

    /**
     * Add Product Nine
     *
     * @param Basket $basket
     * @return Basket
     */
    private function addProductNine(Basket $basket)
    {
        $nine = $this->products->nine();

        $basket->add($nine->sku, $nine->name, $nine->price, function ($product) use ($nine) {
            $product->quantity($nine->quantity);
            $product->freebie($nine->freebie);
            $product->delivery($nine->delivery);
        });

        return $basket;
    }
}
