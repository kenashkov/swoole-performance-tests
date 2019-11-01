# Basic query with pool and caching test

This test performs a query and then a cache read.
In Swoole this is a memory read (as swoole is persistent) and in Apache/mod_php this is implemented with APCu.
This load basically compares the unserialization speed and APCu read spead versus memory access.

The results are:
- Swoole 100 / 10 000 - Requests per second: **53499.11**
- Apache/mod_php 100 / 10 000 - Requests per second: **25141.67**
- Swoole 1 000 / 10 000 - Requests per second: **38591.86**
- Apache/mod_php 1 000 / 10 000 - Requests per second: **1535.84** with **107 failed requests**

#### Swoole 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8082/

[...]

Server Software:        swoole-http-server
Server Hostname:        192.168.0.233
Server Port:            8082

Document Path:          /
Document Length:        792 bytes

Concurrency Level:      100
Time taken for tests:   0.187 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    53499.11 [#/sec] (mean)
Time per request:       1.869 [ms] (mean)
Time per request:       0.019 [ms] (mean, across all concurrent requests)
Transfer rate:          49423.98 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.4      0       6
Processing:     0    2   0.4      2       7
Waiting:        0    2   0.4      2       4
Total:          0    2   0.6      2       9

Percentage of the requests served within a certain time (ms)
  50%      2
  66%      2
  75%      2
  80%      2
  90%      2
  95%      3
  98%      4
  99%      5
 100%      9 (longest request)
```
#### Apache 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests/basic_query_with_pool_and_caching (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic_query_with_pool_and_caching/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic_query_with_pool_and_caching/apache.php
Document Length:        792 bytes

Concurrency Level:      100
Time taken for tests:   0.398 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    9931
Total transferred:      10446982 bytes
HTML transferred:       7920000 bytes
Requests per second:    25141.67 [#/sec] (mean)
Time per request:       3.977 [ms] (mean)
Time per request:       0.040 [ms] (mean, across all concurrent requests)
Transfer rate:          25649.86 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.8      0       8
Processing:     0    4   5.6      3     310
Waiting:        0    4   5.6      3     310
Total:          0    4   5.8      3     318

Percentage of the requests served within a certain time (ms)
  50%      3
  66%      4
  75%      4
  80%      5
  90%      6
  95%      8
  98%     11
  99%     14
 100%    318 (longest request)
```
#### Swoole 1 000 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 1000 -n 10000 -k http://192.168.0.233:8082/

[...]

Server Software:        swoole-http-server
Server Hostname:        192.168.0.233
Server Port:            8082

Document Path:          /
Document Length:        792 bytes

Concurrency Level:      1000
Time taken for tests:   0.259 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    38591.86 [#/sec] (mean)
Time per request:       25.912 [ms] (mean)
Time per request:       0.026 [ms] (mean, across all concurrent requests)
Transfer rate:          35652.25 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    4  13.2      0      62
Processing:     2   18   4.5     18      63
Waiting:        0   18   4.5     18      32
Total:          2   23  14.2     18      84

Percentage of the requests served within a certain time (ms)
  50%     18
  66%     19
  75%     23
  80%     25
  90%     38
  95%     61
  98%     75
  99%     80
 100%     84 (longest request)
```
#### Apache 1000 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 1000 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic_query_with_pool_and_caching/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic_query_with_pool_and_caching/apache.php
Document Length:        792 bytes

Concurrency Level:      1000
Time taken for tests:   6.511 seconds
Complete requests:      10000
Failed requests:        107
   (Connect: 0, Receive: 0, Length: 107, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9865
Total transferred:      10337110 bytes
HTML transferred:       7835256 bytes
Requests per second:    1535.84 [#/sec] (mean)
Time per request:       651.110 [ms] (mean)
Time per request:       0.651 [ms] (mean, across all concurrent requests)
Transfer rate:          1550.40 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    2  11.4      0      82
Processing:     1  162 881.0      4    6425
Waiting:        1  109 723.1      4    6425
Total:          1  164 888.2      4    6499

Percentage of the requests served within a certain time (ms)
  50%      4
  66%      5
  75%      6
  80%      6
  90%      9
  95%     16
  98%   4999
  99%   5005
 100%   6499 (longest request)
``` 