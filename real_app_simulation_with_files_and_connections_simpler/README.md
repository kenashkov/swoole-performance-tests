# Real application simulation with files

This test is a simpler version of [real_app_simluation_with_files_with_connections](../real_app_simluation_with_files_with_connections/) with the following changes:
- included classes: 50
- cache reads: 1000
- file reads: 1
- file writes: 1
- DB queries: 3

This test perhaps is the closest one to a real world application. In such an application most of the data will be cached with few file reads or DB queries.

The results are:
- Swoole 100 / 10 000 - Requests per second: **1919.86**
- Apache/mod_php 100 / 10 000 - Requests per second: **1194.24**
- Swoole 500 / 10 000 - Requests per second: **1824.30**
- Apache/mod_php 500 / 10 000 - Requests per second: **723.21** with **244 failed requests**
- Swoole 1 000 / 10 000 - Requests per second: **1956.75**
- Apache/mod_php 1 000 / 10 000 - Requests per second: **702.33** with **256 failed requests**


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
Time taken for tests:   5.209 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    1919.86 [#/sec] (mean)
Time per request:       52.087 [ms] (mean)
Time per request:       0.521 [ms] (mean, across all concurrent requests)
Transfer rate:          1773.62 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.8      0      10
Processing:    33   51  14.8     50     186
Waiting:       33   51  14.8     50     186
Total:         33   51  15.2     50     191

Percentage of the requests served within a certain time (ms)
  50%     50
  66%     55
  75%     58
  80%     60
  90%     66
  95%     80
  98%     92
  99%    115
 100%    191 (longest request)
```

#### Apache 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/real_app_simulation_with_files_and_connections_simpler/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/real_app_simulation_with_files_and_connections_simpler/apache.php
Document Length:        792 bytes

Concurrency Level:      100
Time taken for tests:   8.374 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    9967
Total transferred:      10448069 bytes
HTML transferred:       7920000 bytes
Requests per second:    1194.24 [#/sec] (mean)
Time per request:       83.735 [ms] (mean)
Time per request:       0.837 [ms] (mean, across all concurrent requests)
Transfer rate:          1218.50 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.6      0      20
Processing:    37   83  18.3     81     296
Waiting:       37   83  18.2     81     296
Total:         37   83  19.0     81     296

Percentage of the requests served within a certain time (ms)
  50%     81
  66%     86
  75%     91
  80%     94
  90%    104
  95%    113
  98%    129
  99%    156
 100%    296 (longest request)
```

#### Swoole 500 / 10 00
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 500 -n 10000 -k http://192.168.0.233:8082/

[...]

Server Software:        swoole-http-server
Server Hostname:        192.168.0.233
Server Port:            8082

Document Path:          /
Document Length:        792 bytes

Concurrency Level:      500
Time taken for tests:   5.482 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    1824.30 [#/sec] (mean)
Time per request:       274.077 [ms] (mean)
Time per request:       0.548 [ms] (mean, across all concurrent requests)
Transfer rate:          1685.34 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    2   8.7      0      55
Processing:    97  262  39.6    251     462
Waiting:       47  262  39.7    251     462
Total:        102  264  39.0    251     498

Percentage of the requests served within a certain time (ms)
  50%    251
  66%    261
  75%    273
  80%    290
  90%    318
  95%    341
  98%    378
  99%    401
 100%    498 (longest request)
```

#### Apache 500 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 500 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/real_app_simulation_with_files_and_connections_simpler/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/real_app_simulation_with_files_and_connections_simpler/apache.php
Document Length:        792 bytes

Concurrency Level:      500
Time taken for tests:   13.827 seconds
Complete requests:      10000
Failed requests:        244
   (Connect: 0, Receive: 0, Length: 244, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9756
Total transferred:      10195276 bytes
HTML transferred:       7726752 bytes
Requests per second:    723.21 [#/sec] (mean)
Time per request:       691.361 [ms] (mean)
Time per request:       1.383 [ms] (mean, across all concurrent requests)
Transfer rate:          720.05 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    1   5.7      0      61
Processing:    38  343 1142.3    122    8368
Waiting:       38  227 872.3    122    8368
Total:         38  344 1145.0    122    8428

Percentage of the requests served within a certain time (ms)
  50%    122
  66%    133
  75%    141
  80%    148
  90%    177
  95%    347
  98%   5006
  99%   8241
 100%   8428 (longest request)
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
Time taken for tests:   5.111 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    1956.75 [#/sec] (mean)
Time per request:       511.052 [ms] (mean)
Time per request:       0.511 [ms] (mean, across all concurrent requests)
Transfer rate:          1807.70 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    7  21.6      0     106
Processing:    35  472  93.1    453    1041
Waiting:       35  472  93.1    453    1041
Total:         43  479  95.8    454    1135

Percentage of the requests served within a certain time (ms)
  50%    454
  66%    467
  75%    478
  80%    491
  90%    587
  95%    685
  98%    803
  99%    861
 100%   1135 (longest request)
```
#### Apache 1 000 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 1000 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/real_app_simulation_with_files_and_connections_simpler/apache.php

[...]

Server Software:        Apache/2.4.25
Server Hostname:        192.168.0.233
Server Port:            8083

Document Path:          /swoole_tests/swoole-performance-tests/real_app_simulation_with_files_and_connections_simpler/apache.php
Document Length:        792 bytes

Concurrency Level:      1000
Time taken for tests:   14.238 seconds
Complete requests:      10000
Failed requests:        256
   (Connect: 0, Receive: 0, Length: 256, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9744
Total transferred:      10182838 bytes
HTML transferred:       7717248 bytes
Requests per second:    702.33 [#/sec] (mean)
Time per request:       1423.829 [ms] (mean)
Time per request:       1.424 [ms] (mean, across all concurrent requests)
Transfer rate:          698.41 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    5  91.0      0    3008
Processing:    38  496 1569.3    220   14080
Waiting:       38  373 1388.9    219   14080
Total:         38  502 1596.0    220   14174

Percentage of the requests served within a certain time (ms)
  50%    220
  66%    232
  75%    240
  80%    246
  90%    286
  95%    404
  98%   5005
  99%  13981
 100%  14174 (longest request)
```