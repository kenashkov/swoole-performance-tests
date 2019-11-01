# Basic class load multiple test

This test has two require_once() statements and loads with class_exists() 100 random classes from the Zend Framework.
class_exists() triggers the autoload (in this case this is Composer's autoload).

The results are:
- Swoole 100 / 10 000 - Requests per second: 53625.63 [#/sec] (mean)
- Apache/mod_php 100 / 10 000 - Requests per second: 2088.27 [#/sec] (mean) with **370 failed requests**
- Swoole 1 000 / 10 000 - Requests per second: 35451.69 [#/sec] (mean)
- Apache/mod_php 1 000 / 10 000 - Requests per second: 683.57 [#/sec] (mean) with **572 failed requests**

As in the [basic_class_load test](../basic_class_load) Apache/mod_php is sufferring from the multiple autoloading. Apache shows high failure rate.

#### Swoole with 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8082/

[...]

Server Software:        swoole-http-server
Server Hostname:        192.168.0.233
Server Port:            8082

Document Path:          /
Document Length:        2 bytes

Concurrency Level:      100
Time taken for tests:   0.186 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      1540000 bytes
HTML transferred:       20000 bytes
Requests per second:    53625.63 [#/sec] (mean)
Time per request:       1.865 [ms] (mean)
Time per request:       0.019 [ms] (mean, across all concurrent requests)
Transfer rate:          8064.79 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.5      0       7
Processing:     0    2   0.6      2      10
Waiting:        0    2   0.6      2      10
Total:          0    2   0.7      2      10

Percentage of the requests served within a certain time (ms)
  50%      2
  66%      2
  75%      2
  80%      2
  90%      2
  95%      3
  98%      4
  99%      5
 100%     10 (longest request)
```

#### Apache with 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic_class_load_multiple/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic_class_load_multiple/apache.php
Document Length:        2 bytes

Concurrency Level:      100
Time taken for tests:   4.789 seconds
Complete requests:      10000
Failed requests:        370
   (Connect: 0, Receive: 0, Length: 370, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9950
Total transferred:      2472132 bytes
HTML transferred:       185020 bytes
Requests per second:    2088.27 [#/sec] (mean)
Time per request:       47.886 [ms] (mean)
Time per request:       0.479 [ms] (mean, across all concurrent requests)
Transfer rate:          504.15 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.5      0      19
Processing:     5   47  34.0     42     339
Waiting:        4   47  34.0     42     339
Total:          5   48  34.0     42     339

Percentage of the requests served within a certain time (ms)
  50%     42
  66%     53
  75%     61
  80%     67
  90%     86
  95%    106
  98%    139
  99%    177
 100%    339 (longest request)
```

#### Swoole 1 000 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 1000 -n 10000 -k http://192.168.0.233:8082/

[...]

Server Software:        swoole-http-server
Server Hostname:        192.168.0.233
Server Port:            8082

Document Path:          /
Document Length:        2 bytes

Concurrency Level:      1000
Time taken for tests:   0.282 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      1540000 bytes
HTML transferred:       20000 bytes
Requests per second:    35451.69 [#/sec] (mean)
Time per request:       28.207 [ms] (mean)
Time per request:       0.028 [ms] (mean, across all concurrent requests)
Transfer rate:          5331.60 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    5  14.8      0      72
Processing:     2   20   3.6     21      72
Waiting:        0   20   3.5     21      35
Total:          2   24  14.8     21      94

Percentage of the requests served within a certain time (ms)
  50%     21
  66%     21
  75%     22
  80%     22
  90%     36
  95%     65
  98%     82
  99%     88
 100%     94 (longest request)
```
#### Apache 1 000 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 1000 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic_class_load_multiple/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic_class_load_multiple/apache.php
Document Length:        2 bytes

Concurrency Level:      1000
Time taken for tests:   14.629 seconds
Complete requests:      10000
Failed requests:        572
   (Connect: 0, Receive: 0, Length: 572, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9724
Total transferred:      2430106 bytes
HTML transferred:       188200 bytes
Requests per second:    683.57 [#/sec] (mean)
Time per request:       1462.898 [ms] (mean)
Time per request:       1.463 [ms] (mean, across all concurrent requests)
Transfer rate:          162.22 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0   37 325.4      0    3011
Processing:     3  342 1505.9      5   12884
Waiting:        0  336 1511.0      5   12884
Total:          3  379 1691.2      5   12959

Percentage of the requests served within a certain time (ms)
  50%      5
  66%      6
  75%      7
  80%      9
  90%     22
  95%   3848
  98%   5747
  99%  10812
 100%  12959 (longest request)
```