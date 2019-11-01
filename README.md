# Swoole performance tests and comparisons

## Introduction

Performance tests of [Swoole](https://www.swoole.co.uk/) against other PHP application server setups. Most of the tests are cumulative - meaning they include everything from the previous and add more.

Apache `ab` tool is used for the tests. The non-informational and repeating part is cut and replaced with [...] in the outputs.

Most tests are run with 1 000 requests per second (concurrency) and 10 000 requests in total unless otherwise noted. KeepAlive is also used on all tests (-k).

## Source

The below are given all the files needed to repeat the test.

- [PHP test files](https://github.com/kenashkov/swoole-performance-tests/)
- [MySQL dump](https://github.com/kenashkov/swoole-performance-tests/blob/master/test_db_dump.sql) - needed for the test connection
- [MySQL connection settings](https://github.com/kenashkov/swoole-performance-tests/blob/master/conn_settings.php) - need to be updated in this file
- [Docker images](https://cloud.docker.com/u/kenashkov/repository/docker/kenashkov/php-tests)
- [Dockerfiles](https://github.com/kenashkov/php-tests-dockerfiles)
- [Zend Framework](https://framework.zend.com/downloads) - to be installed under ./zend_framework with `composer require zendframework/zendframework` for test purpose

The tests were run on:
```
Intel(R) Xeon(R) CPU X5690  @ 3.47GHz - 6 physical cores, 12MB cache
Multithreading enabled - 12 cores
24 GB RAM
Swoole running with 24 workers
Apache running in Prefork tuned for many concurrent connections as per https://oxpedia.org/wiki/index.php?title=Tune_apache2_for_more_concurrent_connections
<IfModule mpm_worker_module>
    ServerLimit              250
    StartServers              10
    MinSpareThreads           75
    MaxSpareThreads          250 
    ThreadLimit               64
    ThreadsPerChild           32
    MaxRequestWorkers       8000
    MaxConnectionsPerChild 10000
</IfModule>

```


```

## Tests and results

A list of the test - please click on each test for more details and complete `ab` output:
- [1] [basic](./basic/) - a "hello world" test
  - Swoole 100 / 10 000 - Requests per second: 52678.71 [#/sec] (mean)
  - Apache/mod_php 100 / 10 000 - Requests per second: 26008.41 [#/sec] (mean)
  - Swoole 1 000 / 10 000 - Requests per second: 34923.27 [#/sec] (mean)
  - Apache/mod_php 1 000 / 10 000 - Requests per second: 1499.39 [#/sec] (mean) with 182 failed requests
- [2] [basic_class_load](./basic_class_load/) - basic + contains 2 require_once() statements
- [3] [basic_class_load_multiple](./basic_class_load_multiple/) - basic_class_load + autoloading (thorugh Composer autoload) 100 classes 
- [4] [basic_query](./basic_query/) - a single DB query
- [5] [basic_query_with_pool](./basic_query_with_pool/) - a single DB query with pooling
- [6] [basic_query_with_pool_and_caching](./basic_query_with_pool_and_caching) - reading cashed results
- [7] [real_app_simulation](./real_app_simulation/) - basic_class_load_multiple + 10 000 cache reads
- [8] [real_app_simulation_with_files](./real_app_simulation_with_files/) - real_app_simulation_with_files + 10 file writes and 10 file reads
- [9] [real_app_simulation_with_files_and_connections](./real_app_simulation_with_files_and_connections/) - real_app_simulation_with_files + 20 DB reads (pooled connection)

## Basic test with require

This test has just two `require_once()` statements.

#### Swoole