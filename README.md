# Swoole performance tests and comparisons

## Introduction

Performance tests of [Swoole](https://www.swoole.co.uk/) against other PHP application server setups.

## Source

- [PHP test files](https://github.com/kenashkov/swoole-performance-tests/)
- [MySQL dump](https://github.com/kenashkov/swoole-performance-tests/blob/master/test_db_dump.sql) - needed for the test connection
- [MySQL connection settings](https://github.com/kenashkov/swoole-performance-tests/blob/master/conn_settings.php) - need to be updated in this file
- [Docker images](https://cloud.docker.com/u/kenashkov/repository/docker/kenashkov/php-tests)
- [Dockerfiles](https://github.com/kenashkov/php-tests-dockerfiles)


## Basic test

This is a purely synthetic test returning "OK" output. A purely synthetic test.

Test files: https://github.com/kenashkov/swoole-performance-tests/tree/master/basic

Swoole:
```
root@vesko-dev /home/vesko/bin # ab -c 1000 -n 100000 -k http://192.168.0.233:8082/
This is ApacheBench, Version 2.3 <$Revision: 1430300 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking 192.168.0.233 (be patient)
Completed 10000 requests
Completed 20000 requests
Completed 30000 requests
Completed 40000 requests
Completed 50000 requests
Completed 60000 requests
Completed 70000 requests
Completed 80000 requests
Completed 90000 requests
Completed 100000 requests
Finished 100000 requests


Server Software:        swoole-http-server
Server Hostname:        192.168.0.233
Server Port:            8082

Document Path:          /
Document Length:        2 bytes

Concurrency Level:      1000
Time taken for tests:   1.949 seconds
Complete requests:      100000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    100000
Total transferred:      15400000 bytes
HTML transferred:       200000 bytes
Requests per second:    51299.91 [#/sec] (mean)
Time per request:       19.493 [ms] (mean)
Time per request:       0.019 [ms] (mean, across all concurrent requests)
Transfer rate:          7715.03 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1   6.0      0      91
Processing:     2   18   2.1     19      91
Waiting:        1   18   2.1     19      42
Total:          2   19   6.9     19     119

Percentage of the requests served within a certain time (ms)
  50%     19
  66%     19
  75%     20
  80%     20
  90%     20
  95%     21
  98%     21
  99%     49
 100%    119 (longest request)
```
 
Apache:
```
root@vesko-dev /home/vesko/bin # ab -c 1000 -n 100000 -k http://192.168.0.233:8083/swoole_tests/basic/apache.php
This is ApacheBench, Version 2.3 <$Revision: 1430300 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking 192.168.0.233 (be patient)
Completed 10000 requests
Completed 20000 requests
Completed 30000 requests
Completed 40000 requests
Completed 50000 requests
Completed 60000 requests
Completed 70000 requests
Completed 80000 requests
Completed 90000 requests
^C

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/basic/apache.php
Document Length:        2 bytes

Concurrency Level:      1000
Time taken for tests:   3.017 seconds
Complete requests:      91697
Failed requests:        0
Write errors:           0
Keep-Alive requests:    90862
Total transferred:      21053700 bytes
HTML transferred:       183394 bytes
Requests per second:    30388.85 [#/sec] (mean)
Time per request:       32.907 [ms] (mean)
Time per request:       0.033 [ms] (mean, across all concurrent requests)
Transfer rate:          6813.77 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1  21.0      0    1011
Processing:     2    8  44.3      4    1971
Waiting:        1    8  44.3      4    1971
Total:          2    9  56.4      4    2923

Percentage of the requests served within a certain time (ms)
  50%      4
  66%      4
  75%      5
  80%      6
  90%      7
  95%      8
  98%     11
  99%     73
 100%   2923 (longest request)
```


