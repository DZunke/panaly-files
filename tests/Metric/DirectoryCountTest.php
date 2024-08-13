<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Test\Metric;

use DZunke\PanalyFiles\Metric\DirectoryCount;
use DZunke\PanalyFiles\Metric\Exception\InvalidOptionGiven;
use PHPUnit\Framework\TestCase;

class DirectoryCountTest extends TestCase
{
    public function testThatTheIdentifierIsCorrect(): void
    {
        self::assertSame('directory_count', (new DirectoryCount())->getIdentifier());
    }

    public function testThatTheDefaultTitleIsCorrect(): void
    {
        self::assertSame('Amount of Directories', (new DirectoryCount())->getDefaultTitle());
    }

    public function testThatTheCalculationWithoutAnyPathInOptionsThrowsAnException(): void
    {
        $this->expectException(InvalidOptionGiven::class);
        $this->expectExceptionMessage('The option "paths" have to be given to analyze a file count.');

        $metric = new DirectoryCount();
        $metric->calculate([]);
    }

    public function testThatTheDirectoryCountAtAPathIsCorrect(): void
    {
        $metric         = new DirectoryCount();
        $directoryCount = $metric->calculate(['paths' => ['tests/Fixtures/FilesystemCount']]);

        self::assertSame(3, $directoryCount->getRaw());
    }

    public function testThatTheDirectoryCountOnUnknownPathsIsFailing(): void
    {
        $this->expectException(InvalidOptionGiven::class);
        $this->expectExceptionMessage('The option "paths" contains paths that are not exists.');

        $metric = new DirectoryCount();
        $metric->calculate(['paths' => ['foo', 'bar']]);
    }
}
