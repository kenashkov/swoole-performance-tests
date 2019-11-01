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
- Apache/mod_php 100 / 10 000 - Requests per second: **1221.60** with **183 failed requests**
- Swoole 1 000 / 10 000 - Requests per second: **1956.75**
- Apache/mod_php 1 000 / 10 000 - Requests per second: **failed with 6776 completed requests**


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
Time taken for tests:   8.186 seconds
Complete requests:      10000
Failed requests:        183
   (Connect: 0, Receive: 0, Length: 183, Exceptions: 0)
Write errors:           0
Keep-Alive requests:    9966
Total transferred:      10529815 bytes
HTML transferred:       8001618 bytes
Requests per second:    1221.60 [#/sec] (mean)
Time per request:       81.860 [ms] (mean)
Time per request:       0.819 [ms] (mean, across all concurrent requests)
Transfer rate:          1256.18 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.4      0      15
Processing:    38   81  25.4     77     282
Waiting:       37   81  25.4     77     282
Total:         38   81  26.1     77     282

Percentage of the requests served within a certain time (ms)
  50%     77
  66%     86
  75%     93
  80%     97
  90%    109
  95%    123
  98%    153
  99%    190
 100%    282 (longest request)
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
apr_socket_recv: Connection reset by peer (104)
Total of 6776 requests completed
```