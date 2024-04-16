<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Metric\Helper;

use DZunke\PanalyFiles\Metric\Exception\InvalidOptionGiven;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;
use Symfony\Component\Finder\Finder;

use function array_filter;
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
            $directories = array_filter($options['paths'], 'is_dir');
            $finder      = (new Finder())->files()->in($directories);
        } catch (DirectoryNotFoundException $e) {
            /**
             * TODO: The exception is currently not thrown anymore because the `is_dir` is filtering for just existing
             *       directories which will not really work as the CODEOWNERS could put in Globs -> Those are not
             *       detected by `is_dir`. There is another solution needed that filters the direct files out of the
             *       globs.
             */
            throw InvalidOptionGiven::givenPathsNotExists($e);
        }

        if (array_key_exists('names', $options) && is_array($options['names'])) {
            $finder->name($options['names']);
        } else {
            // TODO: The file appending should also be done within the finder ... because ownership can deliver single files
            $finder->append(array_filter($options['paths'], 'is_file'));
        }

        return $finder;
    }
}
