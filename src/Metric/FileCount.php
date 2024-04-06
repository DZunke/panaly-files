<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Metric;

use DZunke\PanalyFiles\Metric\Exception\InvalidOptionGiven;
use Panaly\Plugin\Plugin\Metric;
use Panaly\Result\Metric\Integer;
use Panaly\Result\Metric\Value;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;

use function array_key_exists;
use function is_array;

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
        if (! array_key_exists('paths', $options) || ! is_array($options['paths'])) {
            throw InvalidOptionGiven::pathsOptionMustNotBeEmpty();
        }

        try {
            $finder = (new Finder())->files()->in($options['paths']);
        } catch (DirectoryNotFoundException $e) {
            throw InvalidOptionGiven::givenPathsNotExists($e);
        }

        if (array_key_exists('names', $options) && is_array($options['names'])) {
            $finder->name($options['names']);
        }

        return new Integer($finder->count());
    }
}
