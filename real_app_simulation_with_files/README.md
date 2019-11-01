# Real application simulation with files

This test is [real_app_simluation](../real_app_simulation/) with 10 file reads and 10 file writes.

The results are:
- Swoole 100 / 10 000 - Requests per second: **845.97**
- Apache/mod_php 100 / 10 000 - Requests per second: **208.95** with **396 failed requests**
- Swoole 1 000 / 10 000 - Requests per second: **1426.92**
- Apache/mod_php 1 000 / 10 000 - Requests per second: **failed, 1339 requests completed**

When running this test please make sure the ./files directory is writable by Swoole and Apache.

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
Time taken for tests:   11.821 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    845.97 [#/sec] (mean)
Time per request:       118.208 [ms] (mean)
Time per request:       1.182 [ms] (mean, across all concurrent requests)
Transfer rate:          781.53 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.0      0      12
Processing:     5  118  54.0    118     305
Waiting:        5  118  54.0    118     305
Total:          5  118  53.9    118     305

Percentage of the requests served within a certain time (ms)
  50%    118
  66%    147
  75%    161
  80%    170
  90%    189
  95%    203
  98%    218
  99%    230
 100%    305 (longest request)
```
#### Apache 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/real_app_simulation_with_files/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/real_app_simulation_with_files/apache.php
Document Length:        5532 bytes

Concurrency Level:      100
Time taken for tests:   43.492 seconds
Complete requests:      10000
Failed requests:        382
   (Connect: 0, Receive: 0, Length: 382, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9919
Total transferred:      58026811 bytes
HTML transferred:       55490372 bytes
Requests per second:    229.93 [#/sec] (mean)
Time per request:       434.916 [ms] (mean)
Time per request:       4.349 [ms] (mean, across all concurrent requests)
Transfer rate:          1302.94 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.6      0      18
Processing:    48  434 135.0    431    4843
Waiting:       38  433 135.0    431    4843
Total:         49  434 135.7    431    4860

Percentage of the requests served within a certain time (ms)
  50%    431
  66%    438
  75%    442
  80%    445
  90%    453
  95%    461
  98%    470
  99%    477
 100%   4860 (longest request)
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
Time taken for tests:   7.008 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    1426.92 [#/sec] (mean)
Time per request:       700.808 [ms] (mean)
Time per request:       0.701 [ms] (mean, across all concurrent requests)
Transfer rate:          1318.23 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    7  22.7      0     100
Processing:    47  679 272.6    653    1401
Waiting:       15  679 272.6    653    1401
Total:        105  687 264.3    654    1401

Percentage of the requests served within a certain time (ms)
  50%    654
  66%    806
  75%    884
  80%    934
  90%   1085
  95%   1150
  98%   1216
  99%   1249
 100%   1401 (longest request)
```
#### Apache 1 000 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 1000 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/real_app_simulation_with_files/apache.php
This is ApacheBench, Version 2.3 <$Revision: 1430300 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking 192.168.0.233 (be patient)
Completed 1000 requests
apr_socket_recv: Connection reset by peer (104)
Total of 1339 requests completed
```