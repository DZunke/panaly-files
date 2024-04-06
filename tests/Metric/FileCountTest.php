<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Test\Metric;

use DZunke\PanalyFiles\Metric\Exception\InvalidOptionGiven;
use DZunke\PanalyFiles\Metric\FileCount;
use PHPUnit\Framework\TestCase;

class FileCountTest extends TestCase
{
    public function testThatTheIdentifierIsCorrect(): void
    {
        self::assertSame('file_count', (new FileCount())->getIdentifier());
    }

    public function testThatTheDefaultTitleIsCorrect(): void
    {
        self::assertSame('Amount of Files', (new FileCount())->getDefaultTitle());
    }

    public function testThatTheCalculationWithoutAnyPathInOptionsThrowsAnException(): void
    {
        $this->expectException(InvalidOptionGiven::class);
        $this->expectExceptionMessage('The option "paths" have to be given to analyze a file count.');

        $metric = new FileCount();
        $metric->calculate([]);
    }

    public function testThatTheDirectoryCountOnUnknownPathsIsFailing(): void
    {
        $this->expectException(InvalidOptionGiven::class);
        $this->expectExceptionMessage('The option "paths" contains paths that are not exists.');

        $metric = new FileCount();
        $metric->calculate(['paths' => ['foo', 'bar']]);
    }

    public function testThatTheDirectoryCountAtAPathIsCorrect(): void
    {
        $metric    = new FileCount();
        $fileCount = $metric->calculate(['paths' => ['tests/Fixtures/FilesystemCount']]);

        self::assertSame(3, $fileCount->compute());
    }

    public function testThatFilteringForNamesWork(): void
    {
        $metric    = new FileCount();
        $fileCount = $metric->calculate([
            'paths' => ['tests/Fixtures/FilesystemCount'],
            'names' => ['*.js', '*.yaml'],
        ]);

        self::assertSame(2, $fileCount->compute());
    }
}
