# Basic query test

The test does a single query to the database and prints the result. No connection pooling or caching is used.

The results are:
- Swoole 100 / 10 000 - Requests per second: **1804.08**
- Apache/mod_php 100 / 10 000 - Requests per second: **1314.86**
- Swoole 1 000 / 10 000 - Not performed (due to number of DB connection)
- Apache/mod_php 1 000 / 10 000 - Not performed (due to number of DB connections)

In this test Swoole has some advantage because the coroutine aware MySQL client is used. Both will perform much better if connection pooling is used.
As both server will open a number of database connections equal to the number of incoming requests and this will overload the database no tests with 1 000 / 10 000 are performed.

##### Swoole 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8082/

[...]

Server Software:        swoole-http-server
Server Hostname:        192.168.0.233
Server Port:            8082

Document Path:          /
Document Length:        792 bytes

Concurrency Level:      100
Time taken for tests:   5.543 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    10000
Total transferred:      9460000 bytes
HTML transferred:       7920000 bytes
Requests per second:    1804.08 [#/sec] (mean)
Time per request:       55.430 [ms] (mean)
Time per request:       0.554 [ms] (mean, across all concurrent requests)
Transfer rate:          1666.66 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   0.9      0      12
Processing:    10   55 136.6     25     907
Waiting:        3   55 136.6     25     907
Total:         10   55 136.9     25     916

Percentage of the requests served within a certain time (ms)
  50%     25
  66%     26
  75%     28
  80%     30
  90%     37
  95%     57
  98%    666
  99%    677
 100%    916 (longest request)
```
#### Apache 100 / 10 000
```
root@vesko-dev /home/local/swoole_tests/swoole-performance-tests (master) # ab -c 100 -n 10000 -k http://192.168.0.233:8083/swoole_tests/swoole-performance-tests/basic_query/apache.php
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

Document Path:          /swoole_tests/swoole-performance-tests/basic_query/apache.php
Document Length:        792 bytes

Concurrency Level:      100
Time taken for tests:   7.605 seconds
Complete requests:      10000
Failed requests:        0
Write errors:           0
Keep-Alive requests:    9933
Total transferred:      10447109 bytes
HTML transferred:       7920000 bytes
Requests per second:    1314.86 [#/sec] (mean)
Time per request:       76.054 [ms] (mean)
Time per request:       0.761 [ms] (mean, across all concurrent requests)
Transfer rate:          1341.45 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        0    0   1.0      0      12
Processing:     2   67 424.0      8    5556
Waiting:        2   67 424.0      8    5556
Total:          2   67 424.6      8    5562

Percentage of the requests served within a certain time (ms)
  50%      8
  66%     13
  75%     15
  80%     17
  90%     21
  95%     25
  98%   1005
  99%   2526
 100%   5562 (longest request)
```