# Basic class load test

This test has two require_once() statements. 

The results are:
- Swoole 100 / 10 000 - Requests per second: **52451.86**
- Apache/mod_php 100 / 10 000 - Requests per second: **11559.91**
- Swoole 500 / 10 000 - Requests per second: **41044.00**
- Apache/mod_php 500 / 10 000 - Requests per second: **1706.33** with **144 failed requests**
- Swoole 1 000 / 10 000 - Requests per second: **34662.77**
- Apache/mod_php 1 000 / 10 000 - Requests per second: **1339.36** with **161 failed requests**

In this test Swoole performance is unaffected comapred to the [basic test](../basic/) because Swoole loads the file only once before the HTTP server startup.
On the other hand Apache/mod_php performance suffers somewhat (in fact in half in the 100 / 10 000 test) as it loads the files at every request (even with Opcache enabled there is still a cost - please see [PHP RFC: Preloading](https://wiki.php.net/rfc/preload)).

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
Time taken for tests:   0.191 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      1540000 bytes
HTML transferred:       20000 bytes
Requests per second:    52451.86 [#/sec] (mean)
Time per request:       1.907 [ms] (mean)
Time per request:       0.019 [ms] (mean, across all concurrent requests)
Transfer rate:          7888.27 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.7      0      10
Processing:     0    2   0.5      2      11
Waiting:        0    2   0.5      2       5
Total:          0    2   0.9      2      14

Percentage of the requests served within a certain time (ms)
  50%      2
  66%      2
  75%      2
  80%      2
  90%      2
  95%      3
  98%      4
  99%      5
 100%     14 (longest request)
```

#### Apache with 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic_class_load/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic_class_load/apache.php
Document Length:        2 bytes

Concurrency Level:      100
Time taken for tests:   0.865 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    9964
Total transferred:      2298454 bytes
HTML transferred:       20000 bytes
Requests per second:    11559.91 [#/sec] (mean)
Time per request:       8.651 [ms] (mean)
Time per request:       0.087 [ms] (mean, across all concurrent requests)
Transfer rate:          2594.72 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.5      0      19
Processing:     1    8   8.1      6     135
Waiting:        1    8   8.1      6     135
Total:          1    9   8.3      6     135

Percentage of the requests served within a certain time (ms)
  50%      6
  66%      8
  75%     10
  80%     12
  90%     18
  95%     25
  98%     34
  99%     39
 100%    135 (longest request)
```
#### Swoole 500 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 500 -n 10000 -k http://192.168.0.233:8082/

[...]

Server Software:        swoole-http-server
Server Hostname:        192.168.0.233
Server Port:            8082

Document Path:          /
Document Length:        2 bytes

Concurrency Level:      500
Time taken for tests:   0.244 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      1540000 bytes
HTML transferred:       20000 bytes
Requests per second:    41044.00 [#/sec] (mean)
Time per request:       12.182 [ms] (mean)
Time per request:       0.024 [ms] (mean, across all concurrent requests)
Transfer rate:          6172.63 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1   6.1      0      42
Processing:     1   10   1.8     10      42
Waiting:        0   10   1.7     10      21
Total:          1   11   6.5     10      54

Percentage of the requests served within a certain time (ms)
  50%     10
  66%     11
  75%     11
  80%     11
  90%     11
  95%     20
  98%     40
  99%     47
 100%     54 (longest request)
```
#### Apache/mod_php 500 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 500 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic_class_load/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic_class_load/apache.php
Document Length:        2 bytes

Concurrency Level:      500
Time taken for tests:   5.861 seconds
Complete requests:      10000
Failed requests:        144
   (Connect: 0, Receive: 0, Length: 144, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9853
Total transferred:      2267323 bytes
HTML transferred:       19714 bytes
Requests per second:    1706.33 [#/sec] (mean)
Time per request:       293.026 [ms] (mean)
Time per request:       0.586 [ms] (mean, across all concurrent requests)
Transfer rate:          377.81 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    2   8.8      0      60
Processing:     1  161 852.1     13    5791
Waiting:        1   89 619.2     13    5791
Total:          1  162 856.5     13    5849

Percentage of the requests served within a certain time (ms)
  50%     13
  66%     20
  75%     26
  80%     31
  90%     47
  95%     66
  98%   5004
  99%   5608
 100%   5849 (longest request)
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
Time taken for tests:   0.288 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      1540000 bytes
HTML transferred:       20000 bytes
Requests per second:    34662.77 [#/sec] (mean)
Time per request:       28.849 [ms] (mean)
Time per request:       0.029 [ms] (mean, across all concurrent requests)
Transfer rate:          5212.96 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    5  14.1      0      65
Processing:     3   21   3.4     22      65
Waiting:        0   21   3.4     22      41
Total:          3   25  15.4     22      91

Percentage of the requests served within a certain time (ms)
  50%     22
  66%     22
  75%     22
  80%     22
  90%     46
  95%     69
  98%     82
  99%     87
 100%     91 (longest request)

```
#### Apache 1 000 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 1000 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic_class_load/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic_class_load/apache.php
Document Length:        2 bytes

Concurrency Level:      1000
Time taken for tests:   7.466 seconds
Complete requests:      10000
Failed requests:        161
   (Connect: 0, Receive: 0, Length: 161, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9828
Total transferred:      2262837 bytes
HTML transferred:       19678 bytes
Requests per second:    1339.36 [#/sec] (mean)
Time per request:       746.622 [ms] (mean)
Time per request:       0.747 [ms] (mean, across all concurrent requests)
Transfer rate:          295.97 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    2  12.6      0      87
Processing:     1  230 1099.1      8    7375
Waiting:        1  150 914.0      8    7375
Total:          1  232 1106.8      8    7454

Percentage of the requests served within a certain time (ms)
  50%      8
  66%     12
  75%     14
  80%     17
  90%     45
  95%    111
  98%   5830
  99%   5841
 100%   7454 (longest request)
```