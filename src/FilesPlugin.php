<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles;

use DZunke\PanalyFiles\Metric\DirectoryCount;
use DZunke\PanalyFiles\Metric\FileCount;
use DZunke\PanalyFiles\Metric\LargestFiles;
use Panaly\Configuration\ConfigurationFile;
use Panaly\Configuration\RuntimeConfiguration;
use Panaly\Plugin\Plugin;

final class FilesPlugin implements Plugin
{
    /** @inheritDoc */
    public function initialize(
        ConfigurationFile $configurationFile,
        RuntimeConfiguration $runtimeConfiguration,
        array $options,
    ): void {
        $runtimeConfiguration->addMetric(new DirectoryCount());
        $runtimeConfiguration->addMetric(new FileCount());
        $runtimeConfiguration->addMetric(new LargestFiles());
    }
}
