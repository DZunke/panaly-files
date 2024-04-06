<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Test\Metric\Exception;

use DZunke\PanalyFiles\Metric\Exception\InvalidOptionGiven;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;

class InvalidOptionGivenTest extends TestCase
{
    public function testPathsMutNotBeEmpty(): void
    {
        $exception = InvalidOptionGiven::pathsOptionMustNotBeEmpty();

        self::assertSame(
            'The option "paths" have to be given to analyze a file count.',
            $exception->getMessage(),
        );
    }

    public function testGivenPathsNotExist(): void
    {
        $previous  = self::createStub(DirectoryNotFoundException::class);
        $exception = InvalidOptionGiven::givenPathsNotExists($previous);

        self::assertSame(
            'The option "paths" contains paths that are not exists.',
            $exception->getMessage(),
        );
        self::assertSame($previous, $exception->getPrevious());
    }
}
