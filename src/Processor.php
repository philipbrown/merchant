<?php namespace PhilipBrown\Merchant;

class Processor
{
    /**
     * @var Reconciler
     */
    private $reconciler;

    /**
     * @var array
     */
    private $calculators;

    /**
     * Create a new Processor
     *
     * @param Reconciler $reconciler
     * @param array $calculators
     * @return void
     */
    public function __construct(Reconciler $reconciler, $calculators = [])
    {
        $this->reconciler  = $reconciler;
        $this->calculators = $calculators;
    }

    /**
     * Process a Basket into ... ?
     *
     * @param Basket $basket
     * @return array
     */
    public function process(Basket $basket)
    {
        $totals   = $this->totals($basket);
        $products = $this->products($basket);

        return ['totals' => $totals, 'products' => $products];
    }

    /**
     * Process the Calculators
     *
     * @param Basket $basket
     * @return array
     */
    public function totals(Basket $basket)
    {
        $totals = [];

        foreach ($this->calculators as $calculator) {
            $totals[$calculator->name()] = $calculator->calculate($basket);
        }

        return $totals;
    }

    /**
     * Process the Products
     *
     * @param Basket $basket
     * @return array
     */
    public function products(Basket $basket)
    {
        $products = [];

        foreach ($basket->products() as $product) {
            $products[] = [
                'sku'      => $product->sku,
                'name'     => $product->name,
                'price'    => $product->price,
                'rate'     => $product->rate->percentage(),
                'quantity' => $product->quantity,
                'freebie'  => $product->freebie,
                'taxable'  => $product->taxable,
                'delivery' => $product->delivery,
                'coupons'  => $product->coupons->all(),
                'tags'     => $product->tags->all(),
                'discount' => $product->discount ? $product->discount->description() : null,
                'category' => $product->category ? $product->category->name() : null
            ];
        }

        return $products;
    }
}
