<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Test;

use DZunke\PanalyFiles\FilesPlugin;
use DZunke\PanalyFiles\Metric\DirectoryCount;
use DZunke\PanalyFiles\Metric\FileCount;
use DZunke\PanalyFiles\Metric\LargestFiles;
use Panaly\Configuration\ConfigurationFile;
use Panaly\Configuration\RuntimeConfiguration;
use PHPUnit\Framework\TestCase;

class FilesPluginTest extends TestCase
{
    public function testThatAllMetricsAreGiven(): void
    {
        $configurationFile    = $this->createMock(ConfigurationFile::class);
        $runtimeConfiguration = $this->createMock(RuntimeConfiguration::class);

        $matcher = $this->exactly(3);

        $runtimeConfiguration->expects($matcher)
            ->method('addMetric')
            ->willReturnCallback(static function (object $metric) use ($matcher): void {
                match ($matcher->numberOfInvocations()) {
                    1 => self::assertInstanceOf(DirectoryCount::class, $metric),
                    2 => self::assertInstanceOf(FileCount::class, $metric),
                    3 => self::assertInstanceOf(LargestFiles::class, $metric),
                    default => self::fail('Too much is going on here!'),
                };
            });

        (new FilesPlugin())->initialize($configurationFile, $runtimeConfiguration, []);
    }
}
