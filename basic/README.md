# Basic test

This is a purely synthetic test returning "OK" output.
As these tests go the produced output is not relevant to real world application.

In this test run Apache/mod_php on 100 / 10 000 shows a great variance in the results. It seems cache/memory related and sometimes it seves 20 000+ requests per second, while most of the times it is about 2000 per second.
It is to note that in the next test Apache gies persistent 11-12k requests per second so for this test I take the 25705 value as achievable.
But again - this test reflects no real world application so these results are not of such importance.

The results are:
- Swoole 100 / 10 000 - Requests per second: **66308.60**
- Apache/mod_php 100 / 10 000 - Requests per second: **25705.82** (see note above - **1846.98**)
- Swoole 500 / 10 000 - Requests per second: **59658.75**
- Apache/mod_php 500 / 10 000 - Requests per second: **1846.98** with **251 failed requests**
- Swoole 1 000 / 10 000 - Requests per second: **34923.27**
- Apache/mod_php 1 000 / 10 000 - Requests per second: **1499.39** with **182 failed requests**

This test just gives an indication that Swoole is overall twice faster serving simple requests.
This result will be affected if a large class codebase is being loaded - Swoole does this only once, while Apache/mod_php has to load the files on every request (even with Opcache enabled) so in this case Apache/mod_php will be a little slower.
This shortcoming will be addressed in PHP 7.4 (see [Preloading RFC](https://wiki.php.net/rfc/preload)).


#### Swoole with 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://localhost:8082/

[...]

Server Software:        swoole-http-server
Server Hostname:        localhost
Server Port:            8082

Document Path:          /
Document Length:        2 bytes

Concurrency Level:      100
Time taken for tests:   0.151 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      1540000 bytes
HTML transferred:       20000 bytes
Requests per second:    66308.60 [#/sec] (mean)
Time per request:       1.508 [ms] (mean)
Time per request:       0.015 [ms] (mean, across all concurrent requests)
Transfer rate:          9972.19 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.4      0       6
Processing:     0    1   0.8      1      12
Waiting:        0    1   0.8      1      12
Total:          0    1   0.9      1      12

Percentage of the requests served within a certain time (ms)
  50%      1
  66%      2
  75%      2
  80%      2
  90%      2
  95%      3
  98%      4
  99%      5
 100%     12 (longest request)
```
#### Apache/mod_php 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://localhost:8083/swoole_tests/swoole-performance-tests/basic/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        localhost
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic/apache.php
Document Length:        2 bytes

Concurrency Level:      100
Time taken for tests:   5.414 seconds
Complete requests:      10000
Failed requests:        1
   (Connect: 0, Receive: 0, Length: 1, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9931
Total transferred:      2296877 bytes
HTML transferred:       19998 bytes
Requests per second:    1846.98 [#/sec] (mean)
Time per request:       54.143 [ms] (mean)
Time per request:       0.541 [ms] (mean, across all concurrent requests)
Transfer rate:          414.29 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.6      0       8
Processing:     0   15 206.5      3    5001
Waiting:        0   14 200.4      2    4278
Total:          0   15 206.6      3    5001

Percentage of the requests served within a certain time (ms)
  50%      3
  66%      3
  75%      4
  80%      4
  90%      5
  95%      6
  98%     10
  99%     30
 100%   5001 (longest request)
```
#### Apache/mod_php with 100 / 10 000 (an example run with 20 000+ per second)
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://localhost:8083/swoole_tests/swoole-performance-tests/basic/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        localhost
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic/apache.php
Document Length:        2 bytes

Concurrency Level:      100
Time taken for tests:   0.389 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    9946
Total transferred:      2297646 bytes
HTML transferred:       20000 bytes
Requests per second:    25705.82 [#/sec] (mean)
Time per request:       3.890 [ms] (mean)
Time per request:       0.039 [ms] (mean, across all concurrent requests)
Transfer rate:          5767.86 [Kbytes/sec] received                                                                                                                                                                                        
                                                                                                                                                                                                                                             
Connection Times (ms)                                                                                                                                                                                                                        
              min  mean[+/-sd] median   max                                                                                                                                                                                                  
Connect:        0    0   0.6      0       8                                                                                                                                                                                                  
Processing:     0    4   6.8      3     202                                                                                                                                                                                                  
Waiting:        0    4   6.8      3     202                                                                                                                                                                                                  
Total:          0    4   7.0      3     208                                                                                                                                                                                                  
                                                                                                                                                                                                                                             
Percentage of the requests served within a certain time (ms)                                                                                                                                                                                 
  50%      3                                                                                                                                                                                                                                 
  66%      4                                                                                                                                                                                                                                 
  75%      4                                                                                                                                                                                                                                 
  80%      5                                                                                                                                                                                                                                 
  90%      6                                                                                                                                                                                                                                 
  95%      8                                                                                                                                                                                                                                 
  98%     12                                                                                                                                                                                                                                 
  99%     14                                                                                                                                                                                                                                 
 100%    208 (longest request)
```

#### Swoole with 500 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 500 -n 10000 -k http://localhost:8082/

[...]

Server Software:        swoole-http-server
Server Hostname:        localhost
Server Port:            8082

Document Path:          /
Document Length:        2 bytes

Concurrency Level:      500
Time taken for tests:   0.168 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      1540000 bytes
HTML transferred:       20000 bytes
Requests per second:    59658.75 [#/sec] (mean)
Time per request:       8.381 [ms] (mean)
Time per request:       0.017 [ms] (mean, across all concurrent requests)
Transfer rate:          8972.12 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1   3.6      0      22
Processing:     1    7   2.6      7      23
Waiting:        1    7   2.6      7      17
Total:          1    8   4.8      7      32

Percentage of the requests served within a certain time (ms)
  50%      7
  66%      7
  75%      9
  80%     10
  90%     12
  95%     18
  98%     26
  99%     28
 100%     32 (longest request)
```
#### Apache/mod_php 500 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 500 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic/apache.php
Document Length:        2 bytes

Concurrency Level:      500
Time taken for tests:   5.583 seconds
Complete requests:      10000
Failed requests:        251
   (Connect: 0, Receive: 0, Length: 251, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9831
Total transferred:      2271856 bytes
HTML transferred:       19752 bytes
Requests per second:    1791.00 [#/sec] (mean)
Time per request:       279.174 [ms] (mean)
Time per request:       0.558 [ms] (mean, across all concurrent requests)
Transfer rate:          397.35 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1   7.7      0      57
Processing:     1  139 794.9     12    5515
Waiting:        1   54 474.7     12    5515
Total:          1  140 797.6     12    5570

Percentage of the requests served within a certain time (ms)
  50%     12
  66%     13
  75%     14
  80%     14
  90%     21
  95%     48
  98%   4999
  99%   5007
 100%   5570 (longest request)
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