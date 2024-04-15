<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Metric;

use DZunke\PanalyFiles\Metric\Helper\FileFinder;
use Panaly\Plugin\Plugin\Metric;
use Panaly\Result\Metric\Table;
use Panaly\Result\Metric\Value;

use function count;

use const DIRECTORY_SEPARATOR;

class LargestFiles implements Metric
{
    public function getIdentifier(): string
    {
        return 'largest_files';
    }

    public function getDefaultTitle(): string
    {
        return 'Largest Files';
    }

    public function calculate(array $options): Value
    {
        $finder = FileFinder::getFinderByOptions($options);
        $finder->sortBySize()->reverseSorting();

        $fileAmountToShow = $options['amount'] ?? 10;
        $filesToShow      = [];
        foreach ($finder->getIterator() as $file) {
            if (count($filesToShow) >= $fileAmountToShow) {
                break;
            }

            $filesToShow[] = [
                $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename(),
                $file->getSize(),
            ];
        }

        return new Table(['file', 'size'], $filesToShow);
    }
}
