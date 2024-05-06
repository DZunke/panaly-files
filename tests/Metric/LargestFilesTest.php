<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Test\Metric;

use DZunke\PanalyFiles\Metric\Exception\InvalidOptionGiven;
use DZunke\PanalyFiles\Metric\LargestFiles;
use PHPUnit\Framework\TestCase;

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
                ['tests/Fixtures/FilesystemCount/SecondDirectory/foo.yaml', 411],
                ['tests/Fixtures/FilesystemCount/FirstDirectory/RecursiveDirectory/foo.php', 59],
                ['tests/Fixtures/FilesystemCount/FirstDirectory/RecursiveDirectory/bar.js', 55],
            ],
            $fileCount->compute(),
        );
    }

    public function testThatTheFileListingAtAPathWithAnSpecificAmountIsCorrect(): void
    {
        $metric    = new LargestFiles();
        $fileCount = $metric->calculate(['paths' => ['tests/Fixtures/FilesystemCount'], 'amount' => 1]);

        self::assertSame(
            [
                ['file', 'size'],
                ['tests/Fixtures/FilesystemCount/SecondDirectory/foo.yaml', 411],
            ],
            $fileCount->compute(),
        );
    }
}
