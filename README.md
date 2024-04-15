# Panaly - Project Analyzer - Filesystem Plugin

The plugin to the [Panaly Project Analyzer](https://github.com/DZunke/panaly) enables metrics that can be utilized to
collect data about the filesystem of a project. It will not access any tooling but utilizes the
[Symfony Finder Component](https://symfony.com/doc/current/components/finder.html).

## Available Metrics

**Directory Count**

The directory count with the name `directory_count` gives an `Integer` result with the count of found directories.
The following options are available for the metric.

| Option | Description                                  |
|--------|----------------------------------------------|
| paths  | The paths will be combined to a single count | 

**File Count**

The file count with the name `file_count` gives an `Integer` result with the count of found directories. The following
options are available for the metric.

| Option | Description                                                                                                                         |
|--------|-------------------------------------------------------------------------------------------------------------------------------------|
| paths  | **(Required)** *Array* - The paths will be combined to a single count.                                                              | 
| names  | **(Optional)** *Array* - A filter for the names of the files, the possible values are defined by the `Finder` component of symfony. |

**Largest Files**

The metric with the name `largest_files` is able to list the largest files that are given within the paths. 
The Listing could also be filtered by a name and so will just return the largest files of specific filters like with 
the file count. The resulting metric is of type `Table` with the columns `file` and `size`.

| Option | Description                                                                                                                         |
|--------|-------------------------------------------------------------------------------------------------------------------------------------|
| paths  | **(Required)** *Array* - The paths will be combined to a single count.                                                              | 
| names  | **(Optional)** *Array* - A filter for the names of the files, the possible values are defined by the `Finder` component of symfony. |
| amount | **(Optional)** *Integer* *Default: 5* - The amount of files that should be listed in the result.                                    |

## Example Configuration

```yaml
# panaly.dist.yaml
plugins:
    DZunke\PanalyFiles\FilesPlugin: ~ # no options available

groups:
    filesystem:
        title: "Filesystem Metrics"
        metrics:
            file_count:
                title: All Project Files
                paths:
                    - src
            file_count_php:
                title: PHP Files
                metric: file_count
                paths:
                    - src
                    - tests
                names:
                    - "*.php"
            directory_count:
                title: Test Directories
                paths:
                    - tests
            largest_php_files:
                title: Largest PHP Files
                metric: largest_files
                amount: 3
                paths:
                    - src
                    - tests
                names:
                    - "*.php"
```

## Thanks and License

**Panaly Project Analyzer - Filesystem Plugin** © 2024+, Denis Zunke. Released utilizing
the [MIT License](https://mit-license.org/).

> GitHub [@dzunke](https://github.com/DZunke) &nbsp;&middot;&nbsp;
> Twitter [@DZunke](https://twitter.com/DZunke)
