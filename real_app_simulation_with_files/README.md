# Real application simulation with files

This test is [real_app_simluation](../real_app_simulation/) with 10 file reads and 10 file writes.

The results are:
- Swoole 100 / 10 000 - Requests per second: **845.97**
- Apache/mod_php 100 / 10 000 - Requests per second: **220.27**
- Swoole 500 / 10 000 - Requests per second: **1372.28**
- Apache/mod_php 500 / 10 000 - Requests per second: **196.54** with **222 failed requests**
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
Document Length:        792 bytes

Concurrency Level:      100
Time taken for tests:   45.398 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    9930
Total transferred:      10446919 bytes
HTML transferred:       7920000 bytes
Requests per second:    220.27 [#/sec] (mean)
Time per request:       453.983 [ms] (mean)
Time per request:       4.540 [ms] (mean, across all concurrent requests)
Transfer rate:          224.72 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.9      0      22
Processing:    71  453 219.2    442    5504
Waiting:       60  452 219.2    442    5504
Total:         71  453 220.1    443    5526

Percentage of the requests served within a certain time (ms)
  50%    443
  66%    481
  75%    507
  80%    522
  90%    566
  95%    601
  98%    642
  99%    681
 100%   5526 (longest request)
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
Time taken for tests:   7.287 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    1372.28 [#/sec] (mean)
Time per request:       364.357 [ms] (mean)
Time per request:       0.729 [ms] (mean, across all concurrent requests)
Transfer rate:          1267.75 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    2   8.2      0      55
Processing:    61  359 178.6    315    1066
Waiting:       21  359 178.6    315    1066
Total:         71  361 177.8    323    1066

Percentage of the requests served within a certain time (ms)
  50%    323
  66%    421
  75%    486
  80%    527
  90%    631
  95%    694
  98%    757
  99%    794
 100%   1066 (longest request)
```
#### Apache 500 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 500 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/real_app_simulation_with_files/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/real_app_simulation_with_files/apache.php
Document Length:        792 bytes

Concurrency Level:      500
Time taken for tests:   50.881 seconds
Complete requests:      10000
Failed requests:        222
   (Connect: 0, Receive: 0, Length: 222, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9778
Total transferred:      10218288 bytes
HTML transferred:       7744176 bytes
Requests per second:    196.54 [#/sec] (mean)
Time per request:       2544.066 [ms] (mean)
Time per request:       5.088 [ms] (mean, across all concurrent requests)
Transfer rate:          196.12 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1   6.8      0      58
Processing:   110 1389 2430.5   1169   50745
Waiting:       51 1301 2369.2   1160   50745
Total:        110 1390 2433.6   1170   50802

Percentage of the requests served within a certain time (ms)
  50%   1170
  66%   1262
  75%   1332
  80%   1388
  90%   1553
  95%   1730
  98%   5005
  99%   5007
 100%  50802 (longest request)
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