# Basic test

This is a purely synthetic test returning "OK" output.
As these tests go the produced output is not relevant to real world application.
The results are:
- Swoole 100 / 10 000 - Requests per second: **52678.71**
- Apache/mod_php 100 / 10 000 - Requests per second: **26008.41**
- Swoole 1 000 / 10 000 - Requests per second: **34923.27**
- Apache/mod_php 1 000 / 10 000 - Requests per second: **1499.39** with **182 failed requests**

This test just gives an indication that Swoole is overall twice faster serving simple requests.
This result will be affected if a large class codebase is being loaded - Swoole does this only once, while Apache/mod_php has to load the files on every request (even with Opcache enabled) so in this case Apache/mod_php will be a little slower.
This shortcoming will be addressed in PHP 7.4 (see [Preloading RFC](https://wiki.php.net/rfc/preload)).


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
Time taken for tests:   0.190 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      1540000 bytes
HTML transferred:       20000 bytes
Requests per second:    52678.71 [#/sec] (mean)
Time per request:       1.898 [ms] (mean)
Time per request:       0.019 [ms] (mean, across all concurrent requests)
Transfer rate:          7922.38 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.8      0      12
Processing:     0    2   0.6      2      12
Waiting:        0    2   0.6      2       6
Total:          0    2   1.1      2      15

Percentage of the requests served within a certain time (ms)
  50%      2
  66%      2
  75%      2
  80%      2
  90%      3
  95%      3
  98%      4
  99%      7
 100%     15 (longest request)
```
 
#### Apache with 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic/apache.php
Document Length:        2 bytes

Concurrency Level:      100
Time taken for tests:   0.384 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    9940
Total transferred:      2297271 bytes
HTML transferred:       20000 bytes
Requests per second:    26008.41 [#/sec] (mean)
Time per request:       3.845 [ms] (mean)
Time per request:       0.038 [ms] (mean, across all concurrent requests)
Transfer rate:          5834.80 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.7      0       7
Processing:     1    4   1.6      3      23
Waiting:        0    4   1.6      3      22
Total:          1    4   1.9      3      23

Percentage of the requests served within a certain time (ms)
  50%      3
  66%      4
  75%      4
  80%      5
  90%      6
  95%      7
  98%      9
  99%     13
 100%     23 (longest request)
```

#### Swoole with 1 000 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 1000 -n 10000 -k http://192.168.0.233:8082/

[...]

Server Software:        swoole-http-server
Server Hostname:        192.168.0.233
Server Port:            8082

Document Path:          /
Document Length:        2 bytes

Concurrency Level:      1000
Time taken for tests:   0.286 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      1540000 bytes
HTML transferred:       20000 bytes
Requests per second:    34923.27 [#/sec] (mean)
Time per request:       28.634 [ms] (mean)
Time per request:       0.029 [ms] (mean, across all concurrent requests)
Transfer rate:          5252.13 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    5  14.0      0      64
Processing:     3   21   4.1     22      64
Waiting:        0   21   4.1     22      41
Total:          3   25  15.4     22      91

Percentage of the requests served within a certain time (ms)
  50%     22
  66%     22
  75%     24
  80%     24
  90%     46
  95%     68
  98%     82
  99%     86
 100%     91 (longest request)
```

#### Apache 1 000 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 1000 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic/apache.php
Document Length:        2 bytes

Concurrency Level:      1000
Time taken for tests:   6.669 seconds
Complete requests:      10000
Failed requests:        182
   (Connect: 0, Receive: 0, Length: 182, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9818
Total transferred:      2258524 bytes
HTML transferred:       19636 bytes
Requests per second:    1499.39 [#/sec] (mean)
Time per request:       666.938 [ms] (mean)
Time per request:       0.667 [ms] (mean, across all concurrent requests)
Transfer rate:          330.70 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    2  11.8      0      85
Processing:     1  214 1036.4      8    6581
Waiting:        1  123 806.0      8    6581
Total:          1  217 1043.0      8    6661

Percentage of the requests served within a certain time (ms)
  50%      8
  66%      9
  75%     10
  80%     10
  90%     17
  95%     73
  98%   5005
  99%   5521
 100%   6661 (longest request)