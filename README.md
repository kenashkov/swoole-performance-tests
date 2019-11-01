# Swoole performance tests and comparisons

## Introduction

Performance tests of [Swoole](https://www.swoole.co.uk/) against other PHP application server setups. Most of the tests are cumulative - meaning they include everything from the previous and add more.

Apache `ab` tool is used for the tests. The non-informational and repeating part is cut and replaced with [...] in the outputs.

Most tests are run with 100 requests per second (concurrency) and 10 000 requests (denoted 100 / 10 000 in the results) and/or 1 000 and 10 000 respectively (whenever possible/practical due to the high load). KeepAlive is also used on all tests (-k).

It is important to note that in certain tests running multiple times `ab` against Apache/mod_php does show a little better results (up to 20% improvement). Because of this Apache/mod_php is always given "a second chance" in the tests below.

There are also variations between the Swoole runs but these are smaller (about 10%). The average of these is taken for the results.

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

The MySQL instance used for testing is MySQL 8 on another host in the same network with connection limit of 4000.

## Tests and results

A list of the test - please click on each test for more details and complete `ab` output:
- [1] **[basic](./basic/)** - a "hello world" test
  - Swoole 100 / 10 000 - Requests per second: **52678.71**
  - Apache/mod_php 100 / 10 000 - Requests per second: **26008.41**
  - Swoole 1 000 / 10 000 - Requests per second: **34923.27**
  - Apache/mod_php 1 000 / 10 000 - Requests per second: **1499.39** with **182 failed requests**
- [2] **[basic_class_load](./basic_class_load/)** - [basic](./basic/) + contains 2 require_once() statements
  - Swoole 100 / 10 000 - Requests per second: **52451.86**
  - Apache/mod_php 100 / 10 000 - Requests per second: **11559.91**
  - Swoole 1 000 / 10 000 - Requests per second: **34662.77**
  - Apache/mod_php 1 000 / 10 000 - Requests per second: **1339.36** with **161 failed requests**
- [3] **[basic_class_load_multiple](./basic_class_load_multiple/)** - [basic_class_load](./basic_class_load/) + autoloading (thorugh Composer autoload) 100 classes 
  - Swoole 100 / 10 000 - Requests per second: **53625.63**
  - Apache/mod_php 100 / 10 000 - Requests per second: **2088.27** with **370 failed requests**
  - Swoole 1 000 / 10 000 - Requests per second: **35451.69**
  - Apache/mod_php 1 000 / 10 000 - Requests per second: **683.57** with **572 failed requests**
- [4] **[basic_query](./basic_query/)** - a single DB query
  - Swoole 100 / 10 000 - Requests per second: **1804.08**
  - Apache/mod_php 100 / 10 000 - Requests per second: **1314.86**
  - Swoole 1 000 / 10 000 - Not performed (due to number of DB connection)
  - Apache/mod_php 1 000 / 10 000 - Not performed (due to number of DB connections)
- [5] **[basic_query_with_pool](./basic_query_with_pool/)** - [basic_query](./basic_query/) + connection pooling (in Apache this is using persistent connections)
  - Swoole 100 / 10 000 - Requests per second: **4163.17**
  - Apache/mod_php 100 / 10 000 - Requests per second: **2327.34**
  - Swoole 1 000 / 10 000 - Requests per second: **4326.38**
  - Apache/mod_php 1 000 / 10 000 - Requests per second: **failed, 9547 requests completed**
- [6] **[basic_query_with_pool_and_caching](./basic_query_with_pool_and_caching)** - reading cashed results (the query matters only for the first read so does not really rely on basic_query_with_pool)
  - Swoole 100 / 10 000 - Requests per second: **53499.11**
  - Apache/mod_php 100 / 10 000 - Requests per second: **25141.67**
  - Swoole 1 000 / 10 000 - Requests per second: **38591.86**
  - Apache/mod_php 1 000 / 10 000 - Requests per second: **1535.84** with **107 failed requests**
- [7] **[real_app_simulation](./real_app_simulation/)** - [basic_class_load_multiple](./basic_class_load_multiple/) + 10 000 cache reads
  - Swoole 100 / 10 000 - Requests per second: **15195.12**
  - Apache/mod_php 100 / 10 000 - Requests per second: **232.29** with **364 failed requests**
  - Swoole 1 000 / 10 000 - Requests per second: **14635.35**
  - Apache/mod_php 1 000 / 10 000 - Requests per second: **failed, 1266 requests completed**
- [8] **[real_app_simulation_with_files](./real_app_simulation_with_files/)** - [real_app_simulation_with_files](./real_app_simulation_with_files/) + 10 file writes and 10 file reads
  - Swoole 100 / 10 000 - Requests per second: **845.97**
  - Apache/mod_php 100 / 10 000 - Requests per second: **208.95** with **396 failed requests**
  - Swoole 1 000 / 10 000 - Requests per second: **1426.92**
  - Apache/mod_php 1 000 / 10 000 - Requests per second: **failed, 1339 requests completed**
- [9] **[real_app_simulation_with_files_and_connections](./real_app_simulation_with_files_and_connections/)** - [real_app_simulation_with_files](./real_app_simulation_with_files/) + 20 DB reads (pooled connection)
  - Swoole 100 / 10 000 - Requests per second: **285.91**
  - Apache/mod_php 100 / 10 000 - Requests per second: **134.77** with **396 failed requests**
  - Swoole 1 000 / 10 000 - Requests per second: **314.33**
  - Apache/mod_php 1 000 / 10 000 - Requests per second: **108.94** with **558 failed requests**

## Aggregated results and Graphs


## Conclusion