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
     * @var array
     */
    private static $currencies;

    /**
     * Create a new Money Formatter
     *
     * @param string $locale
     * @return void
     */
    public function __construct($locale)
    {
        $this->locale = $locale;

        if (! isset(static::$currencies)) {
           static::$currencies = json_decode(file_get_contents(__DIR__.'/currencies.json'));
        }
    }

    /**
     * Format an input to an output
     *
     * @param mixed $value
     * @return mixed
     */
    public function format($value)
    {
        $formatter = new NumberFormatter($this->locale,  NumberFormatter::CURRENCY);

        $code     = $this->code($value);
        $divisor  = $this->divisor($code);
        $amount   = $this->convert($value, $divisor);

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

    /**
     * Convert subunits to units
     *
     * @param Money $money
     * @param int $divisor
     * @return float
     */
    private function convert(Money $money, $divisor)
    {
        return number_format(($money->getAmount() / $divisor), 2, '.', '');
    }
}
