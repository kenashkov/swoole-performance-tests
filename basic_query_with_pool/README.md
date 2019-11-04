# Basic query with pool test

Swoole uses Pool implementation based on Swoole\Channel and Apache/mod_php uses MySQLi persistent connections.

The results are:
- Swoole 100 / 10 000 - Requests per second: **4163.17**
- Apache/mod_php 100 / 10 000 - Requests per second: **2327.34**
- Swoole 500 / 10 000 - Requests per second: **4279.57**
- Apache/mod_php 500 / 10 000 - Requests per second: **1059.98** with **228 failed requests**
- Swoole 1 000 / 10 000 - Requests per second: **4326.38**
- Apache/mod_php 1 000 / 10 000 - Requests per second: **failed, 9547 requests completed**

Both show much better performance than the non-pooled test.
It is important to note that the persistent connections in MySQLi do perform [additional connection cleanup](https://www.php.net/manual/en/mysqli.persistconns.php) when the connection is returned back to the pool.
In Swoole this is left to the developer to ensure the connection that is returned to the pool is in clean state.
So Apache/mod_php to match Swoole behaviour it needs to be compiled with MYSQLI_NO_CHANGE_USER_ON_PCONNECT defined.
This test is performed on a standard PHP config where this is not set.

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
Time taken for tests:   2.402 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    4163.17 [#/sec] (mean)
Time per request:       24.020 [ms] (mean)
Time per request:       0.240 [ms] (mean, across all concurrent requests)
Transfer rate:          3846.06 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.8      0      11
Processing:     1   24   6.6     23     104
Waiting:        1   24   6.6     23     104
Total:          1   24   6.7     23     108

Percentage of the requests served within a certain time (ms)
  50%     23
  66%     26
  75%     27
  80%     28
  90%     31
  95%     33
  98%     45
  99%     50
 100%    108 (longest request)
```
#### Apache 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic_query_with_pool/apache.php
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

Document Path:          /swoole_tests/swoole-performance-tests/basic_query_with_pool/apache.php
Document Length:        792 bytes

Concurrency Level:      100
Time taken for tests:   4.297 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    9958
Total transferred:      10447772 bytes
HTML transferred:       7920000 bytes
Requests per second:    2327.34 [#/sec] (mean)
Time per request:       42.968 [ms] (mean)
Time per request:       0.430 [ms] (mean, across all concurrent requests)
Transfer rate:          2374.56 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.0      0      10
Processing:     2   43  30.6     40    2326
Waiting:        2   43  30.6     40    2326
Total:          2   43  30.8     40    2335

Percentage of the requests served within a certain time (ms)
  50%     40
  66%     42
  75%     44
  80%     46
  90%     57
  95%     62
  98%     67
  99%     70
 100%   2335 (longest request)
```
#### Swoole 500 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8082/

[...]

Server Software:        swoole-http-server
Server Hostname:        192.168.0.233
Server Port:            8082

Document Path:          /
Document Length:        792 bytes

Concurrency Level:      100
Time taken for tests:   2.337 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    4279.57 [#/sec] (mean)
Time per request:       23.367 [ms] (mean)
Time per request:       0.234 [ms] (mean, across all concurrent requests)
Transfer rate:          3953.58 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.8      0      11
Processing:     1   23   6.8     23     102
Waiting:        1   23   6.8     23     102
Total:          1   23   7.0     23     107

Percentage of the requests served within a certain time (ms)
  50%     23
  66%     25
  75%     27
  80%     28
  90%     30
  95%     32
  98%     44
  99%     50
 100%    107 (longest request)
```
#### Apache/mod_php 500 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 500 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic_query_with_pool/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic_query_with_pool/apache.php
Document Length:        792 bytes

Concurrency Level:      500
Time taken for tests:   9.434 seconds
Complete requests:      10000
Failed requests:        228
   (Connect: 0, Receive: 0, Length: 228, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9772
Total transferred:      10212012 bytes
HTML transferred:       7739424 bytes
Requests per second:    1059.98 [#/sec] (mean)
Time per request:       471.709 [ms] (mean)
Time per request:       0.943 [ms] (mean, across all concurrent requests)
Transfer rate:          1057.08 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1   6.2      0      56
Processing:     2  241 854.2     95    9372
Waiting:        2  128 447.3     93    9372
Total:          2  242 855.6     95    9428

Percentage of the requests served within a certain time (ms)
  50%     95
  66%    106
  75%    111
  80%    116
  90%    135
  95%    160
  98%   5004
  99%   5005
 100%   9428 (longest request)
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
Time taken for tests:   2.311 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    4326.38 [#/sec] (mean)
Time per request:       231.140 [ms] (mean)
Time per request:       0.231 [ms] (mean, across all concurrent requests)
Transfer rate:          3996.83 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    6  20.1      0     101
Processing:    29  210  36.5    209     346
Waiting:        2  210  36.6    209     346
Total:         32  216  32.2    210     355

Percentage of the requests served within a certain time (ms)
  50%    210
  66%    216
  75%    221
  80%    229
  90%    254
  95%    295
  98%    317
  99%    325
 100%    355 (longest request)
```
#### Apache/mod_php 1 000 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 1000 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic_query_with_pool/apache.php
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
apr_socket_recv: Connection reset by peer (104)
Total of 9547 requests completed
```
