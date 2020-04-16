# Hyperf AMQP

辅助 Hyperf 的 AMQP 客户端，案例文档 [hyperf-api-case](https://hyperf.kainonly.com)

![Packagist Version](https://img.shields.io/packagist/v/kain/hyperf-amqp.svg?style=flat-square)
![Packagist](https://img.shields.io/packagist/dt/kain/hyperf-amqp.svg?color=blue&style=flat-square)
![PHP from Packagist](https://img.shields.io/packagist/php-v/kain/hyperf-amqp.svg?color=blue&style=flat-square)
![Packagist](https://img.shields.io/packagist/l/kain/hyperf-amqp.svg?color=blue&style=flat-square)

#### 安装

```shell
composer require kain/hyperf-amqp
```

> 当信道结束后连接也会自动断开不会持久建立，因此适用灵活的临时触发场景，不建议用于订阅消费等功能