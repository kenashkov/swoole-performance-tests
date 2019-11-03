# Swoole performance tests and comparisons

## Introduction

Performance tests of [Swoole](https://www.swoole.co.uk/) against other PHP application server setups. Most of the tests are cumulative - meaning they include everything from the previous and add more.

Apache `ab` tool is used for the tests. The non-informational and repeating part is cut and replaced with [...] in the outputs.

Most tests are run with 100 requests per second (concurrency) and 10 000 requests (denoted 100 / 10 000 in the results) and/or 1 000 and 10 000 respectively (whenever possible/practical due to the high load). KeepAlive is also used on all tests (-k).

It is important to note that in certain tests running multiple times `ab` against Apache/mod_php does show a little better results (up to 20% improvement). Because of this Apache/mod_php is always given "a second chance" in the tests below.

There are also variations between the Swoole runs but these are smaller (about 10%). The average of these is taken for the results.

These tests are attempt to show different aspects of Swoole and also a comparison between Swoole and Apache/mod_php in tests close to real world applications.

Please create a **Pull Request** if you think there is a mistake or there is a test you would like to add or more tuning to either Swoole or Apache that could/should be done.

## Source

The below are given all the files needed to repeat the test.

- [PHP test files](https://github.com/kenashkov/swoole-performance-tests/)
- [MySQL dump](https://github.com/kenashkov/swoole-performance-tests/blob/master/test_db_dump.sql) - needed for the test connection
- [MySQL connection settings](https://github.com/kenashkov/swoole-performance-tests/blob/master/conn_settings.php) - need to be updated in this file
- [Docker images](https://cloud.docker.com/u/kenashkov/repository/docker/kenashkov/php-tests)
- [Dockerfiles](https://github.com/kenashkov/php-tests-dockerfiles)
- [Zend Framework](https://framework.zend.com/downloads) - to be installed under ./zend_framework with `composer require zendframework/zendframework` for test purpose

The tests were done on:
```
Swoole container: PHP 7.3.10 & Swoole 4.4.10 (note - at the time of writing this is not yet officially released, the build was done on 31st Oct 2019)
Apache/mod_php container: Apache 2.4.25 & PHP 7.3.10
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
Swoole is running with 24 workers (and 5 DB connections per Worker in the DB Pools whenever this is applicable)
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
- [10] **[real_app_simulation_with_files_and_connections_simpler](./real_app_simulation_with_files_and_connections_simpler/)** - [real_app_simulation_with_files_and_connections](./real_app_simulation_with_files_and_connections/) but with less loaded classes and cache/file/db reads
  - Swoole 100 / 10 000 - Requests per second: **1919.86**
  - Apache/mod_php 100 / 10 000 - Requests per second: **1221.60** with **183 failed requests**
  - Swoole 1 000 / 10 000 - Requests per second: **1956.75**
  - Apache/mod_php 1 000 / 10 000 - Requests per second: **failed with 6776 completed requests**
- [11] **[simple_real_app_simulation](./simple_real_app_simulation)** - 1000 reads from cache, loads 100 classes and performs 2 fast DB queries.
  - Swoole 100 / 10 000 - Requests per second: **2288.58**
  - Apache/mod_php 100 / 10 000 - Requests per second: **1057.52** with **355 failed requests**
  - Swoole 1 000 / 10 000 - Requests per second: **2228.23**
  - Apache/mod_php 1 000 / 10 000 - Requests per second: **failed with 7702 completed requests**

## Aggregated results and Graphs

[TBD]

## Conclusion

Performance conclusions:
- based on test [1] Swoole is twice as fast as Apache/mod_php in handling connections and returning response.
- based on tests [2] and [3] it is clear the advantage Swoole has when loading php files/classes - it is done only once before server start.
- based on tests [4] and [5] we can say that if the persistent connections are not used Swoole has clear advantage. When persistent connections are used Swoole is around twice faster - the result from test [1].  
The persistent connections in PHP need to be very well controlled as otherwise they can take up to the maximum allowed by the DB.
In Swoole it is very easy to control the number of the connections in the Pool. They are the product of the number of Workers and the number of allocated connections per pool. In our tests this is 24 workers * 5 connections = 120.
- test [7] shows the expected - Swoole is king in caching as it can use the local PHP memory for that.
- tests [8] and [9] simulate load closer to a real world application. Here Swoole coroutines and persistent memory give the advantage. The drop in the performance of Swoole in [9] is due to the SLEEP(0.01) in the query. This is expected and is put here to show that in applications where the slowest part are the DB queries by just running these on Swoole will not improve much the performance.
What will improve the performance in this case is to run some (most if possible) of the queries in parallel by using sub-coroutines. This is possible only if the queries are independent of each other.
Also both these tests show more requests served under higher load - this I attribute to the async operations performed in these tests and Swoole relying on the coroutines for these.
- test [10] is a simpler version of [9] and it repeats its results
- test [11] is just a representation of what a real world Swoole application should aim to be - use as much as possible caching and few IO operations. The amount of loaded classes does not affect the performance. 

Overall conclusion:
- in simple applications or microservices Swoole will excel as these will be mostly cached. Swoole leads here as it loads the classes only ones and can use memory for all the caching.
- In more complex applications the difference between Swoole and Apache/mod_php is about 1.8-2 times - this is due to the fact that the speed is greatly reduced by the IO operations. Swoole is still more efficient here due to the coroutines.
If the application can be optimized to use caching as much as possible Swoole will perform better as there is no serialization/unserialization and access to external storage (be it even shared memory access).
An app/service that uses mostly caching and perhaps a single fast read IO operation can be scaled to 4-5 000 requests per second.
If there are no IO operations (for example Swoole\Table can be used for sharing data between the Workers) then the requests can reach 10-20 000 per second (test [6] shows 53 000 but this drops when there is actual business logic to be executed).
- Swoole can serve more requests than Apache and there was no a single failed request in all the tests.
- Swoole is a step further both in speed and the load that can be sustained compared to Apache/mod_php

Swoole does not execute PHP faster that any other setup. If your application uses heavy processing in PHP it will not benefit that much if you switch to Swoole.

Swoole can also serve as a traditional web server (static_handler & document_root need to be enabled) but it is better to offload the static handling to Apache or Nginx.
Swoole also supports HTTP2 and HTTPS but these were not included in the tests. And there is also a Websocket server!

One last thing to note is that the tests were done on a 6 core processor. Modern servers are usually dual socket and are 8-10 cores per socket so the actual results if you run the same tests on your server will be better.
Of course running actual code will produce different results.

## Additional resources

- [English documentation](http://swoole.co.uk) - some parts of the documentation are outdated.
- [Chinese documentation](https://wiki.swoole.com/) - Google Translate does a decent job and I strongly recommend this resource. Besides current documentation there are also many technical details/advanced sections provided.
- [Coroutines in Swoole](http://vesko.blogs.azonmedia.com/2019/09/19/coroutines-in-swoole/) - Introduction and examples by me in Coroutines in Swoole.