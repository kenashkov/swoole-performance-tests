# Swoole performance tests and comparisons

## Introduction

Performance tests of [Swoole](https://www.swoole.co.uk/) against other PHP application server setups.

## Source

The below are given all the files needed to repeat the test.

- [PHP test files](https://github.com/kenashkov/swoole-performance-tests/)
- [MySQL dump](https://github.com/kenashkov/swoole-performance-tests/blob/master/test_db_dump.sql) - needed for the test connection
- [MySQL connection settings](https://github.com/kenashkov/swoole-performance-tests/blob/master/conn_settings.php) - need to be updated in this file
- [Docker images](https://cloud.docker.com/u/kenashkov/repository/docker/kenashkov/php-tests)
- [Dockerfiles](https://github.com/kenashkov/php-tests-dockerfiles)

The tests were run on:
```
Intel(R) Xeon(R) CPU X5690  @ 3.47GHz - 6 physical cores, 12MB cache
Multithreading enabled - 12 cores
24 GB RAM
Swoole running with 24 workers
Apache running in Prefork
        StartServers                     200
        MinSpareServers           50
        MaxSpareServers          100
        MaxRequestWorkers         1100
        MaxConnectionsPerChild   0

```

## Basic test

This is a purely synthetic [test](https://github.com/kenashkov/swoole-performance-tests/tree/master/basic) returning "OK" output.
As these tests go the produced output is not relevant to real world application.
Still, the basic results are:
- Swoole - Requests per second: 51430.28 [#/sec] (mean)
- Apache/mod_php - Requests per second: 24559.40 [#/sec] (mean)

This test just gives an indication that Swoole is overall twice faster serving simple requests.
This result will be affected if a large class codebase is being loaded - Swoole does this only once, while Apache/mod_php has to load the files on every request (even with Opcache enabled) so in this case Apache/mod_php will be a little slower.
This shortcoming will be addressed in PHP 7.4 (see [Preloading RFC](https://wiki.php.net/rfc/preload)).


Swoole:
```
root@vesko-dev /home/vesko/bin # ab -c 100 -n 10000 -k http://192.168.0.233:8082/
This is ApacheBench, Version 2.3 <$Revision: 1430300 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking 192.168.0.233 (be patient)
Completed 1000 requests
Completed 2000 requests
Completed 3000 requests
Completed 4000 requests
Completed 5000 requests
Completed 6000 requests
Completed 7000 requests
Completed 8000 requests
Completed 9000 requests
Completed 10000 requests
Finished 10000 requests


Server Software:        swoole-http-server
Server Hostname:        192.168.0.233
Server Port:            8082

Document Path:          /
Document Length:        2 bytes

Concurrency Level:      100
Time taken for tests:   0.194 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      1540000 bytes
HTML transferred:       20000 bytes
Requests per second:    51430.28 [#/sec] (mean)
Time per request:       1.944 [ms] (mean)
Time per request:       0.019 [ms] (mean, across all concurrent requests)
Transfer rate:          7734.63 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.9      0      13
Processing:     0    2   0.6      2      13
Waiting:        0    2   0.6      2       5
Total:          0    2   1.1      2      17

Percentage of the requests served within a certain time (ms)
  50%      2
  66%      2
  75%      2
  80%      2
  90%      3
  95%      3
  98%      4
  99%      6
 100%     17 (longest request)
```
 
Apache:
```
root@vesko-dev /home/vesko/bin # ab -c 100 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic/apache.php
This is ApacheBench, Version 2.3 <$Revision: 1430300 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking 192.168.0.233 (be patient)
Completed 1000 requests
Completed 2000 requests
Completed 3000 requests
Completed 4000 requests
Completed 5000 requests
Completed 6000 requests
Completed 7000 requests
Completed 8000 requests
Completed 9000 requests
Completed 10000 requests
Finished 10000 requests


Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic/apache.php
Document Length:        2 bytes

Concurrency Level:      100
Time taken for tests:   0.407 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    9948
Total transferred:      2297621 bytes
HTML transferred:       20000 bytes
Requests per second:    24559.40 [#/sec] (mean)
Time per request:       4.072 [ms] (mean)
Time per request:       0.041 [ms] (mean, across all concurrent requests)
Transfer rate:          5510.57 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.1      0      12
Processing:     0    4   2.0      3      20
Waiting:        0    4   2.0      3      20
Total:          0    4   2.6      3      29

Percentage of the requests served within a certain time (ms)
  50%      3
  66%      4
  75%      5
  80%      5
  90%      6
  95%      8
  98%     11
  99%     20
 100%     29 (longest request)
```

