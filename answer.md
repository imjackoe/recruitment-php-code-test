+ 题目1
  + ./vendor/bin/phpunit ./tests/Service/ProductHandlerTest2.php
+ 题目2
  + ./vendor/bin/phpunit ./tests/App/DemoTest.php 由于提供的url无法访问，导致会出现失败。
+ 题目3
  + 基于静态工厂+适配+单例模式进行拓展
+ 题目4
  + \App\Service\Common::geoHelperAddress
    + 缓存用户地址时候未在原有的缓存时间上添加随机的时间，在同一时间缓存同时失效时会造成雪崩；
    + 记录日志应该使用一个通用的日志类处理；
    + 代码书写不规范，有部分时驼峰有部分时带下划线；
    + 状态码/业务码应该使用枚举值维护，而不应该硬编码；
  + \App\Service\Common::checkStatusCallback
    + 状态码/业务码应该使用枚举值维护，而不应该硬编码；
    + 代码书写不规范，有部分时驼峰有部分时带下划线；
