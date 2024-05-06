<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Metric;

use DZunke\PanalyFiles\Metric\Exception\InvalidOptionGiven;
use Panaly\Plugin\Plugin\Metric;
use Panaly\Result\Metric\IntegerValue;
use Panaly\Result\Metric\Value;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;

use function array_key_exists;
use function is_array;

class DirectoryCount implements Metric
{
    public function getIdentifier(): string
    {
        return 'directory_count';
    }

    public function getDefaultTitle(): string
    {
        return 'Amount of Directories';
    }

    public function calculate(array $options): Value
    {
        if (! array_key_exists('paths', $options) || ! is_array($options['paths'])) {
            throw InvalidOptionGiven::pathsOptionMustNotBeEmpty();
        }

        try {
            $directoryCount = (new Finder())->directories()->in($options['paths'])->count();
        } catch (DirectoryNotFoundException $e) {
            throw InvalidOptionGiven::givenPathsNotExists($e);
        }

        return new IntegerValue($directoryCount);
    }
}
