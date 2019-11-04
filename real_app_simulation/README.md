# Real application simulation test

This test combines [basic_class_load_multiple](./basic_class_load_multiple/) and 10 000 cache reads.
In Swoole the cache is just a memory read, in Apache/mod_php this is APCu read.
There is also a Pool class but this is not really used - only for the first connection.

The results are:
- Swoole 100 / 10 000 - Requests per second: **15195.12**
- Apache/mod_php 100 / 10 000 - Requests per second: **228.51**
- Swoole 100 / 10 000 - Requests per second: **15771.75**
- Apache/mod_php 100 / 10 000 - Requests per second: **197.57** with **153 failed requests**
- Swoole 1 000 / 10 000 - Requests per second: **14635.35**
- Apache/mod_php 1 000 / 10 000 - Requests per second: **failed, 1266 requests completed**

This test really compares unserialization and APCu reads versus plain memory read. Because of this Apache shows much better results.

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
Time taken for tests:   0.658 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    15195.12 [#/sec] (mean)
Time per request:       6.581 [ms] (mean)
Time per request:       0.066 [ms] (mean, across all concurrent requests)
Transfer rate:          14037.68 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.8      0      11
Processing:     1    6   5.9      4      53
Waiting:        1    6   5.9      4      53
Total:          1    6   6.0      4      53

Percentage of the requests served within a certain time (ms)
  50%      4
  66%      6
  75%      7
  80%      8
  90%     15
  95%     23
  98%     24
  99%     28
 100%     53 (longest request)
```
#### Apache 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/real_app_simulation/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/real_app_simulation/apache.php
Document Length:        792 bytes

Concurrency Level:      100
Time taken for tests:   43.762 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    9973
Total transferred:      10448837 bytes
HTML transferred:       7920000 bytes
Requests per second:    228.51 [#/sec] (mean)
Time per request:       437.618 [ms] (mean)
Time per request:       4.376 [ms] (mean, across all concurrent requests)
Transfer rate:          233.17 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.7      0      21
Processing:    52  436 479.5    425    7077
Waiting:       42  436 479.5    425    7077
Total:         52  436 481.0    425    7098

Percentage of the requests served within a certain time (ms)
  50%    425
  66%    444
  75%    459
  80%    468
  90%    499
  95%    529
  98%    565
  99%    616
 100%   7098 (longest request)
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
Time taken for tests:   0.634 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    15771.75 [#/sec] (mean)
Time per request:       31.702 [ms] (mean)
Time per request:       0.063 [ms] (mean, across all concurrent requests)
Transfer rate:          14570.39 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1   5.0      0      32
Processing:     3   29  12.8     30      84
Waiting:        1   29  12.8     30      84
Total:          3   30  12.8     30      92

Percentage of the requests served within a certain time (ms)
  50%     30
  66%     33
  75%     36
  80%     39
  90%     48
  95%     54
  98%     58
  99%     62
 100%     92 (longest request)
```
#### Apache 500 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -s 120 -c 500 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/real_app_simulation/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/real_app_simulation/apache.php
Document Length:        792 bytes

Concurrency Level:      500
Time taken for tests:   50.616 seconds
Complete requests:      10000
Failed requests:        153
   (Connect: 0, Receive: 0, Length: 153, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9847
Total transferred:      10290462 bytes
HTML transferred:       7798824 bytes
Requests per second:    197.57 [#/sec] (mean)
Time per request:       2530.807 [ms] (mean)
Time per request:       5.062 [ms] (mean, across all concurrent requests)
Transfer rate:          198.54 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1   5.1      0      38
Processing:    33 1697 5034.9   1067   50532
Waiting:       33 1639 5018.2   1065   50532
Total:         61 1698 5038.8   1067   50567

Percentage of the requests served within a certain time (ms)
  50%   1067
  66%   1181
  75%   1254
  80%   1299
  90%   1439
  95%   1596
  98%   5006
  99%  21089
 100%  50567 (longest request)
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
Time taken for tests:   0.683 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    14635.35 [#/sec] (mean)
Time per request:       68.328 [ms] (mean)
Time per request:       0.068 [ms] (mean, across all concurrent requests)
Transfer rate:          13520.55 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    5  14.5      0      71
Processing:    12   57  21.7     59     155
Waiting:        1   57  21.7     59     155
Total:         14   61  20.4     61     155

Percentage of the requests served within a certain time (ms)
  50%     61
  66%     68
  75%     75
  80%     78
  90%     87
  95%     92
  98%    104
  99%    115
 100%    155 (longest request)
```
#### Apache 1 000 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 1000 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/real_app_simulation/apache.php
This is ApacheBench, Version 2.3 <$Revision: 1430300 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking 192.168.0.233 (be patient)
Completed 1000 requests
apr_socket_recv: Connection reset by peer (104)
Total of 1266 requests completed
``` 