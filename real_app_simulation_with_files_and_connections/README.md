# Real application simulation with files

This test is [real_app_simluation_with_files](../real_app_simulation_with_files/) with 20 db reads with connection pool

The results are:
- Swoole 100 / 10 000 - Requests per second: **285.91**
- Apache/mod_php 100 / 10 000 - Requests per second: **141.24**
- Swoole 500 / 10 000 - Requests per second: **285.32**
- Apache/mod_php 500 / 10 000 - Requests per second: **115.82** with **249 failed requests**
- Swoole 1 000 / 10 000 - Requests per second: **314.33**
- Apache/mod_php 1 000 / 10 000 - Requests per second: **failed, 1159 requests completed**

When running this test please make sure the ./files directory is writable by Swoole and Apache.

It is important to note that Swoole can execute the file reads and he queries in parallel (with sub-coroutines) is these are independent of each other.
The given example is not taking advantage of this (in real world application at least some of the queries will be independent and can be run in parallel).

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
Time taken for tests:   34.976 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    285.91 [#/sec] (mean)
Time per request:       349.759 [ms] (mean)
Time per request:       3.498 [ms] (mean, across all concurrent requests)
Transfer rate:          264.13 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.9      0      12
Processing:   224  346  84.2    370     995
Waiting:      224  346  84.2    370     995
Total:        224  346  84.5    370    1002

Percentage of the requests served within a certain time (ms)
  50%    370
  66%    398
  75%    410
  80%    418
  90%    436
  95%    450
  98%    478
  99%    576
 100%   1002 (longest request)
```
#### Apache 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/real_app_simulation_with_files_and_connections/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/real_app_simulation_with_files_and_connections/apache.php
Document Length:        3282 bytes

Concurrency Level:      100
Time taken for tests:   70.801 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    9956
Total transferred:      35357722 bytes
HTML transferred:       32820000 bytes
Requests per second:    141.24 [#/sec] (mean)
Time per request:       708.011 [ms] (mean)
Time per request:       7.080 [ms] (mean, across all concurrent requests)
Transfer rate:          487.69 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   2.1      0      25
Processing:   240  703 132.3    732    1290
Waiting:      240  703 132.3    732    1290
Total:        240  703 132.8    732    1314

Percentage of the requests served within a certain time (ms)
  50%    732
  66%    759
  75%    774
  80%    784
  90%    812
  95%    840
  98%    866
  99%    898
 100%   1314 (longest request)

```
#### Swoole 500 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 500 -n 10000 -k http://192.168.0.233:8082/

[...]

Server Software:        swoole-http-server
Server Hostname:        192.168.0.233
Server Port:            8082

Document Path:          /
Document Length:        792 bytes

Concurrency Level:      500
Time taken for tests:   35.048 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    285.32 [#/sec] (mean)
Time per request:       1752.397 [ms] (mean)
Time per request:       3.505 [ms] (mean, across all concurrent requests)
Transfer rate:          263.59 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    3  39.6      0    1003
Processing:   269 1691 194.0   1691    4027
Waiting:      245 1691 194.1   1691    4027
Total:        280 1694 194.7   1692    4079

Percentage of the requests served within a certain time (ms)
  50%   1692
  66%   1727
  75%   1751
  80%   1770
  90%   1827
  95%   1883
  98%   1953
  99%   2068
 100%   4079 (longest request)
```
#### Apache 500 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 500 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/real_app_simulation_with_files_and_connections/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/real_app_simulation_with_files_and_connections/apache.php
Document Length:        3282 bytes

Concurrency Level:      500
Time taken for tests:   86.339 seconds
Complete requests:      10000
Failed requests:        249
   (Connect: 0, Receive: 0, Length: 249, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9756
Total transferred:      34497472 bytes
HTML transferred:       32019192 bytes
Requests per second:    115.82 [#/sec] (mean)
Time per request:       4316.953 [ms] (mean)
Time per request:       8.634 [ms] (mean, across all concurrent requests)
Transfer rate:          390.19 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    5 120.2      0    3007
Processing:   272 2179 1009.8   2322   10326
Waiting:      259 2101 916.7   2313   10326
Total:        272 2184 1041.9   2322   10373

Percentage of the requests served within a certain time (ms)
  50%   2322
  66%   2448
  75%   2511
  80%   2547
  90%   2676
  95%   2807
  98%   5005
  99%   5922
 100%  10373 (longest request)
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
Time taken for tests:   31.813 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    314.33 [#/sec] (mean)
Time per request:       3181.322 [ms] (mean)
Time per request:       3.181 [ms] (mean, across all concurrent requests)
Transfer rate:          290.39 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    6  19.9      0      99
Processing:   336 2989 431.9   3058    3818
Waiting:      237 2989 431.9   3058    3818
Total:        336 2995 417.3   3060    3904

Percentage of the requests served within a certain time (ms)
  50%   3060
  66%   3116
  75%   3152
  80%   3173
  90%   3260
  95%   3341
  98%   3441
  99%   3499
 100%   3904 (longest request)
```
#### Apache 1 000 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -s 120 -c 1000 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/real_app_simulation_with_files_and_connections/apache.php
This is ApacheBench, Version 2.3 <$Revision: 1430300 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking 192.168.0.233 (be patient)
Completed 1000 requests
apr_socket_recv: Connection reset by peer (104)
Total of 1159 requests completed
```