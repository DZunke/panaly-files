<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Metric\Exception;

use InvalidArgumentException;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;

final class InvalidOptionGiven extends InvalidArgumentException
{
    public static function pathsOptionMustNotBeEmpty(): InvalidOptionGiven
    {
        return new self('The option "paths" have to be given to analyze a file count.');
    }

    public static function givenPathsNotExists(DirectoryNotFoundException $previous): InvalidOptionGiven
    {
        return new self(
            message: 'The option "paths" contains paths that are not exists.',
            previous: $previous,
        );
    }
}
