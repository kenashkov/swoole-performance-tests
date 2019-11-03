# Real application simulation with files

This test is [real_app_simluation_with_files](../real_app_simulation_with_files/) with 20 db reads with connection pool

The results are:
- Swoole 100 / 10 000 - Requests per second: **285.91**
- Apache/mod_php 100 / 10 000 - Requests per second: **134.77** with **396 failed requests**
- Swoole 500 / 10 000 - Requests per second: **285.32**
- Apache/mod_php 500 / 10 000 - Requests per second: **122.17** with **640 failed requests**
- Swoole 1 000 / 10 000 - Requests per second: **314.33**
- Apache/mod_php 1 000 / 10 000 - Requests per second: **108.94** with **558 failed requests**

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
Document Length:        1010 bytes

Concurrency Level:      100
Time taken for tests:   74.201 seconds
Complete requests:      10000
Failed requests:        9992
   (Connect: 0, Receive: 0, Length: 9992, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9965
Total transferred:      10606447 bytes
HTML transferred:       8077834 bytes
Requests per second:    134.77 [#/sec] (mean)
Time per request:       742.006 [ms] (mean)
Time per request:       7.420 [ms] (mean, across all concurrent requests)
Transfer rate:          139.59 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.9      0      10
Processing:   237  736 493.5    753    7071
Waiting:      236  736 493.5    753    7071
Total:        237  736 494.3    753    7079

Percentage of the requests served within a certain time (ms)
  50%    753
  66%    798
  75%    822
  80%    837
  90%    871
  95%    900
  98%    987
  99%   1314
 100%   7079 (longest request)
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
Time taken for tests:   81.851 seconds
Complete requests:      10000
Failed requests:        640
   (Connect: 0, Receive: 0, Length: 640, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9756
Total transferred:      34674088 bytes
HTML transferred:       32195808 bytes
Requests per second:    122.17 [#/sec] (mean)
Time per request:       4092.561 [ms] (mean)
Time per request:       8.185 [ms] (mean, across all concurrent requests)
Transfer rate:          413.69 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1   5.7      0      45
Processing:   278 2076 848.5   2193    6394
Waiting:      252 2006 725.5   2188    6394
Total:        278 2077 849.1   2193    6422

Percentage of the requests served within a certain time (ms)
  50%   2193
  66%   2364
  75%   2464
  80%   2526
  90%   2685
  95%   2790
  98%   5005
  99%   5007
 100%   6422 (longest request)
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
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 1000 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/real_app_simulation_with_files_and_connections/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/real_app_simulation_with_files_and_connections/apache.php
Document Length:        792 bytes

Concurrency Level:      1000
Time taken for tests:   91.791 seconds
Complete requests:      10000
Failed requests:        558
   (Connect: 0, Receive: 0, Length: 558, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9778
Total transferred:      10368075 bytes
HTML transferred:       7893586 bytes
Requests per second:    108.94 [#/sec] (mean)
Time per request:       9179.112 [ms] (mean)
Time per request:       9.179 [ms] (mean, across all concurrent requests)
Transfer rate:          110.31 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    5 123.9      0    7011
Processing:   236 2889 7189.7   2424   90905
Waiting:      236 2814 7185.2   2395   90905
Total:        236 2894 7199.1   2424   90972

Percentage of the requests served within a certain time (ms)
  50%   2424
  66%   2562
  75%   2635
  80%   2714
  90%   2889
  95%   6038
  98%   8733
  99%  11675
 100%  90972 (longest request)
```