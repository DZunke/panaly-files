<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Test\Metric;

use DZunke\PanalyFiles\Metric\Exception\InvalidOptionGiven;
use DZunke\PanalyFiles\Metric\LargestFiles;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class LargestFilesTest extends TestCase
{
    public function testThatTheIdentifierIsCorrect(): void
    {
        self::assertSame(
            'largest_files',
            (new LargestFiles())->getIdentifier(),
        );
    }

    public function testThatTheDefaultTitleIsCorrect(): void
    {
        self::assertSame(
            'Largest Files',
            (new LargestFiles())->getDefaultTitle(),
        );
    }

    public function testThatTheCalculationWithoutAnyPathInOptionsThrowsAnException(): void
    {
        $this->expectException(InvalidOptionGiven::class);
        $this->expectExceptionMessage('The option "paths" have to be given to analyze a file count.');

        $metric = new LargestFiles();
        $metric->calculate([]);
    }

    public function testThatTheFileListingAtAPathIsCorrect(): void
    {
        $metric    = new LargestFiles();
        $fileCount = $metric->calculate(['paths' => ['tests/Fixtures/FilesystemCount']]);

        self::assertSame(
            [
                ['file', 'size'],
                ['tests/Fixtures/FilesystemCount/SecondDirectory/foo.yaml', '411 B'],
                ['tests/Fixtures/FilesystemCount/FirstDirectory/RecursiveDirectory/foo.php', '59 B'],
                ['tests/Fixtures/FilesystemCount/FirstDirectory/RecursiveDirectory/bar.js', '55 B'],
            ],
            $fileCount->format(),
        );
    }

    public function testThatTheFileListingAtAPathWithAnSpecificAmountIsCorrect(): void
    {
        $metric    = new LargestFiles();
        $fileCount = $metric->calculate(['paths' => ['tests/Fixtures/FilesystemCount'], 'amount' => 1]);

        self::assertSame(
            [
                ['file', 'size'],
                ['tests/Fixtures/FilesystemCount/SecondDirectory/foo.yaml', '411 B'],
            ],
            $fileCount->format(),
        );
    }

    #[DataProvider('fileSizeProvider')]
    public function testFormatFileSize(int $size, string $expected): void
    {
        $methodReflection = new ReflectionMethod(LargestFiles::class, 'formatFileSize');
        $largestFiles     = new LargestFiles();

        self::assertSame($expected, $methodReflection->invoke($largestFiles, $size));
    }

    /** @return Generator<string, array{int, string}> */
    public static function fileSizeProvider(): Generator
    {
        yield '1 GB' => [1_073_741_824, '1.00 GB'];
        yield '1 MB' => [1_048_576, '1.00 MB'];
        yield '1 KB' => [1_024, '1.00 KB'];
        yield '512 B' => [512, '512 B'];
    }
}
