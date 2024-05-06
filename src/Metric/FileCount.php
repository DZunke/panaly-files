<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Metric;

use DZunke\PanalyFiles\Metric\Helper\FileFinder;
use Panaly\Plugin\Plugin\Metric;
use Panaly\Result\Metric\IntegerValue;
use Panaly\Result\Metric\Value;

class FileCount implements Metric
{
    public function getIdentifier(): string
    {
        return 'file_count';
    }

    public function getDefaultTitle(): string
    {
        return 'Amount of Files';
    }

    public function calculate(array $options): Value
    {
        $finder = FileFinder::getFinderByOptions($options);

        return new IntegerValue($finder->count());
    }
}
