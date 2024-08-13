<?php

declare(strict_types=1);

namespace DZunke\PanalyFiles\Metric;

use DZunke\PanalyFiles\Metric\Helper\FileFinder;
use Panaly\Plugin\Plugin\Metric;
use Panaly\Result\Metric\Table;
use Panaly\Result\Metric\Value;
use Symfony\Component\Finder\Finder;

use function count;
use function number_format;

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
        $filesToShow      = $this->getFilesToShow($finder, $fileAmountToShow);

        return new Table(['file', 'size'], $filesToShow);
    }

    /** @return list<array{0: string, 1: string}> */
    private function getFilesToShow(Finder $finder, int $fileAmountToShow): array
    {
        $filesToShow = [];
        foreach ($finder->getIterator() as $file) {
            if (count($filesToShow) >= $fileAmountToShow) {
                break;
            }

            $filesToShow[] = [
                $file->getPath() . DIRECTORY_SEPARATOR . $file->getFilename(),
                $this->formatFileSize($file->getSize()),
            ];
        }

        return $filesToShow;
    }

    private function formatFileSize(int $size): string
    {
        if ($size >= 1_073_741_824) {
            return number_format($size / 1_073_741_824, 2) . ' GB';
        }

        if ($size >= 1_048_576) {
            return number_format($size / 1_048_576, 2) . ' MB';
        }

        if ($size >= 1_024) {
            return number_format($size / 1_024, 2) . ' KB';
        }

        return number_format($size) . ' B';
    }
}
