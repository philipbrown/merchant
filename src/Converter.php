<?php namespace PhilipBrown\Merchant;

use ReflectionClass;
use PhilipBrown\Merchant\Formatters\MoneyFormatter;
use PhilipBrown\Merchant\Formatters\PercentFormatter;
use PhilipBrown\Merchant\Formatters\TaxRateFormatter;
use PhilipBrown\Merchant\Formatters\CollectionFormatter;

class Converter
{
    /**
     * @var array
     */
    private $formatters;

    /**
     * Create a new Converter
     *
     * @param string $locale
     * @param array $formatters
     * @return void
     */
    public function __construct($locale, array $formatters = [])
    {
        $bootstrap = [
            'Collection'         => new CollectionFormatter,
            'Percent'            => new PercentFormatter,
            'TaxRate'            => new TaxRateFormatter,
            'Money'              => new MoneyFormatter($locale),
            'ValueDiscount'      => new MoneyFormatter($locale),
            'PercentageDiscount' => new PercentFormatter
        ];

        $this->formatters = array_merge($bootstrap, $formatters);
    }

    /**
     * Convert a value using to the appropriate format
     *
     * @param mixed $value
     * @return mixed
     */
    public function convert($value)
    {
        if (! is_object($value)) return $value;

        return $this->formatter($value)->format($value);
    }

    /**
     * Get the Formatter for an object
     *
     * @param mixed $object
     * @return Formatter
     */
    public function formatter($object)
    {
        if ($object instanceOf TaxRate) {
            return $this->formatters['TaxRate'];
        }

        $class = array_pop(explode('\\', get_class($object)));

        return $this->formatters[$class];
    }
}
