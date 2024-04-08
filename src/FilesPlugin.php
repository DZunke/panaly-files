<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles;

use DZunke\PanalyFiles\Metric\DirectoryCount;
use DZunke\PanalyFiles\Metric\FileCount;
use Panaly\Plugin\BasePlugin;

final class FilesPlugin extends BasePlugin
{
    /** @inheritDoc */
    public function getAvailableMetrics(array $options): array
    {
        return [
            new DirectoryCount(),
            new FileCount(),
        ];
    }
}
