<?php namespace PhilipBrown\Merchant\Formatters;

use Money\Money;
use NumberFormatter;
use PhilipBrown\Merchant\Formatter;

class MoneyFormatter implements Formatter
{
    /**
     * @var string
     */
    private $locale;

    /**
     * @var Money
     */
    private $value;

    /**
     * Create a new Money Formatter
     *
     * @param Money $value
     * @return void
     */
    public function __construct($locale, Money $value)
    {
        $this->locale = $locale;
        $this->value  = $value;
    }

    /**
     * Format an input to an output
     *
     * @return mixed
     */
    public function format()
    {
        $formatter = new NumberFormatter($this->locale,  NumberFormatter::CURRENCY);

        $amount   = $this->value->getAmount();
        $amount   = number_format(($amount / 100), 2, '.', '');
        $currency = $this->value->getCurrency()->getName();

        return $formatter->formatCurrency($amount,  $currency);
    }
}
