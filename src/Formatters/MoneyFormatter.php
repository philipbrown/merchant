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
     * @var array
     */
    private static $currencies;

    /**
     * Create a new Money Formatter
     *
     * @param string $locale
     * @param Money $value
     * @return void
     */
    public function __construct($locale, Money $value)
    {
        $this->locale = $locale;
        $this->value  = $value;

        if (! isset(static::$currencies)) {
           static::$currencies = json_decode(file_get_contents(__DIR__.'/currencies.json'));
        }
    }

    /**
     * Format an input to an output
     *
     * @return mixed
     */
    public function format()
    {
        $formatter = new NumberFormatter($this->locale,  NumberFormatter::CURRENCY);

        $code     = $this->code($this->value);
        $divisor  = $this->divisor($code);
        $amount   = number_format(($this->value->getAmount() / $divisor), 2, '.', '');

        return $formatter->formatCurrency($amount,  $code);
    }

    /**
     * Get the currency ISO Code
     *
     * @param Money $value
     * @return string
     */
    private function code(Money $value)
    {
        return $value->getCurrency()->getName();
    }

    /**
     * Get the subunits to units divisor
     *
     * @param string $code
     * @return int
     */
    private function divisor($code)
    {
        return static::$currencies->$code->subunit_to_unit;
    }
}
