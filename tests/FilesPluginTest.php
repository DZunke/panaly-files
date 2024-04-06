<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Test;

use DZunke\PanalyFiles\FilesPlugin;
use DZunke\PanalyFiles\Metric\DirectoryCount;
use DZunke\PanalyFiles\Metric\FileCount;
use Panaly\Plugin\Plugin\Metric;
use PHPUnit\Framework\TestCase;

use function array_map;

class FilesPluginTest extends TestCase
{
    public function testThatAllMetricsAreGiven(): void
    {
        $plugin  = new FilesPlugin();
        $metrics = $plugin->getAvailableMetrics();

        self::assertCount(2, $metrics);
        self::assertSame(
            [DirectoryCount::class, FileCount::class],
            array_map(
                static fn (Metric $metric) => $metric::class,
                $metrics,
            ),
        );
    }

    public function testThatThereIsNoStorageGiven(): void
    {
        self::assertCount(
            0,
            (new FilesPlugin())->getAvailableStorages(),
        );
    }

    public function testThatThereIsNoReportingGiven(): void
    {
        self::assertCount(
            0,
            (new FilesPlugin())->getAvailableReporting(),
        );
    }
}
