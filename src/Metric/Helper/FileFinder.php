<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Metric\Helper;

use DZunke\PanalyFiles\Metric\Exception\InvalidOptionGiven;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;

use function array_key_exists;
use function is_array;

final class FileFinder
{
    private function __construct()
    {
    }

    public static function getFinderByOptions(array $options): Finder
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

        return $finder;
    }
}
