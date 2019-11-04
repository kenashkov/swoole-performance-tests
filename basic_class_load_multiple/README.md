# Basic class load multiple test

This test has two require_once() statements and loads with class_exists() 100 random classes from the Zend Framework.
class_exists() triggers the autoload (in this case this is Composer's autoload).

The results are:
- Swoole 100 / 10 000 - Requests per second: **53625.63**
- Apache/mod_php 100 / 10 000 - Requests per second: **2073.61**
- Swoole 500 / 10 000 - Requests per second: **39887.20**
- Apache/mod_php 500 / 10 000 - Requests per second: **1010.27** with **187 failed requests**
- Swoole 1 000 / 10 000 - Requests per second: **35451.69**
- Apache/mod_php 1 000 / 10 000 - Requests per second: **1016.76** with **238 failed requests**

As in the [basic_class_load test](../basic_class_load) Apache/mod_php is sufferring from the multiple autoloading. Apache shows high failure rate.

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
Time taken for tests:   0.186 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      1540000 bytes
HTML transferred:       20000 bytes
Requests per second:    53625.63 [#/sec] (mean)
Time per request:       1.865 [ms] (mean)
Time per request:       0.019 [ms] (mean, across all concurrent requests)
Transfer rate:          8064.79 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.5      0       7
Processing:     0    2   0.6      2      10
Waiting:        0    2   0.6      2      10
Total:          0    2   0.7      2      10

Percentage of the requests served within a certain time (ms)
  50%      2
  66%      2
  75%      2
  80%      2
  90%      2
  95%      3
  98%      4
  99%      5
 100%     10 (longest request)
```

#### Apache/mod_php with 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic_class_load_multiple/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic_class_load_multiple/apache.php
Document Length:        2 bytes

Concurrency Level:      100
Time taken for tests:   4.823 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    9958
Total transferred:      2298159 bytes
HTML transferred:       20000 bytes
Requests per second:    2073.61 [#/sec] (mean)
Time per request:       48.225 [ms] (mean)
Time per request:       0.482 [ms] (mean, across all concurrent requests)
Transfer rate:          465.38 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.8      0      24
Processing:     5   48  28.2     45     215
Waiting:        4   48  28.1     45     215
Total:          5   48  28.2     45     215

Percentage of the requests served within a certain time (ms)
  50%     45
  66%     55
  75%     63
  80%     68
  90%     85
  95%    101
  98%    122
  99%    136
 100%    215 (longest request)
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
Time taken for tests:   0.251 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      1540000 bytes
HTML transferred:       20000 bytes
Requests per second:    39887.20 [#/sec] (mean)
Time per request:       12.535 [ms] (mean)
Time per request:       0.025 [ms] (mean, across all concurrent requests)
Transfer rate:          5998.66 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1   6.3      0      43
Processing:     1   10   1.9     10      43
Waiting:        0   10   1.8     10      22
Total:          1   11   6.8     10      56

Percentage of the requests served within a certain time (ms)
  50%     10
  66%     11
  75%     11
  80%     11
  90%     12
  95%     22
  98%     41
  99%     50
 100%     56 (longest request)
```
#### Apache/mod_php 500 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 500 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic_class_load_multiple/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic_class_load_multiple/apache.php
Document Length:        2 bytes

Concurrency Level:      500
Time taken for tests:   9.898 seconds
Complete requests:      10000
Failed requests:        187
   (Connect: 0, Receive: 0, Length: 187, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9808
Total transferred:      2257076 bytes
HTML transferred:       19626 bytes
Requests per second:    1010.27 [#/sec] (mean)
Time per request:       494.916 [ms] (mean)
Time per request:       0.990 [ms] (mean, across all concurrent requests)
Transfer rate:          222.68 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1   7.4      0      57
Processing:     4  278 1095.7     78    9824
Waiting:        4  187 881.5     77    9824
Total:          4  280 1099.9     78    9881

Percentage of the requests served within a certain time (ms)
  50%     78
  66%     99
  75%    114
  80%    124
  90%    161
  95%    221
  98%   5006
  99%   5229
 100%   9881 (longest request)
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
Time taken for tests:   0.282 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      1540000 bytes
HTML transferred:       20000 bytes
Requests per second:    35451.69 [#/sec] (mean)
Time per request:       28.207 [ms] (mean)
Time per request:       0.028 [ms] (mean, across all concurrent requests)
Transfer rate:          5331.60 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    5  14.8      0      72
Processing:     2   20   3.6     21      72
Waiting:        0   20   3.5     21      35
Total:          2   24  14.8     21      94

Percentage of the requests served within a certain time (ms)
  50%     21
  66%     21
  75%     22
  80%     22
  90%     36
  95%     65
  98%     82
  99%     88
 100%     94 (longest request)
```
#### Apache/mod_php 1 000 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 1000 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic_class_load_multiple/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/basic_class_load_multiple/apache.php
Document Length:        2 bytes

Concurrency Level:      1000
Time taken for tests:   9.835 seconds
Complete requests:      10000
Failed requests:        238
   (Connect: 0, Receive: 0, Length: 238, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9762
Total transferred:      2245556 bytes
HTML transferred:       19524 bytes
Requests per second:    1016.76 [#/sec] (mean)
Time per request:       983.514 [ms] (mean)
Time per request:       0.984 [ms] (mean, across all concurrent requests)
Transfer rate:          222.97 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    2  11.8      0      82
Processing:     5  278 956.4    119    9713
Waiting:        4  161 607.0    117    9713
Total:          5  280 958.6    120    9777

Percentage of the requests served within a certain time (ms)
  50%    120
  66%    147
  75%    165
  80%    177
  90%    215
  95%    262
  98%   5006
  99%   5016
 100%   9777 (longest request)
```