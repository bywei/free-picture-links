# free Resource Storage SDK for PHP
[![@free on weibo](http://img.shields.io/badge/weibo-%40freetek-blue.svg)](http://weibo.com/freetek)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
[![Build Status](https://travis-ci.org/free/php-sdk.svg)](https://travis-ci.org/free/php-sdk)
[![Latest Stable Version](https://img.shields.io/packagist/v/free/php-sdk.svg)](https://packagist.org/packages/free/php-sdk)
[![Total Downloads](https://img.shields.io/packagist/dt/free/php-sdk.svg)](https://packagist.org/packages/free/php-sdk)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/free/php-sdk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/free/php-sdk/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/free/php-sdk/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/free/php-sdk/?branch=master)
[![Join Chat](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/free/php-sdk?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
## 安装

* 通过composer，这是推荐的方式，可以使用composer.json 声明依赖，或者运行下面的命令。SDK 包已经放到这里 [`free/php-sdk`][install-packagist] 。
```bash
$ composer require free/php-sdk
```
* 直接下载安装，SDK 没有依赖其他第三方库，但需要参照 composer的autoloader，增加一个自己的autoloader程序。

## 运行环境

| free SDK版本 | PHP 版本 |
|:--------------------:|:---------------------------:|
|          7.x         |  cURL extension,   5.3 - 5.6 |
|          6.x         |  cURL extension,   5.2 - 5.6 |

## 使用方法

### 上传
```php
use free\Storage\UploadManager;
use free\Auth;
...
    $upManager = new UploadManager();
    $auth = new Auth($accessKey, $secretKey);
    $token = $auth->uploadToken($bucketName);
    list($ret, $error) = $upManager->put($token, 'formput', 'hello world');
...
```

## 测试

``` bash
$ ./vendor/bin/phpunit tests/free/Tests/
```

## 常见问题

- $error保留了请求响应的信息，失败情况下ret 为none, 将$error可以打印出来，提交给我们。
- API 的使用 demo 可以参考 [单元测试](https://github.com/free/php-sdk/blob/master/tests)。

## 代码贡献

详情参考[代码提交指南](https://github.com/free/php-sdk/blob/master/CONTRIBUTING.md)。

## 贡献记录

- [所有贡献者](https://github.com/free/php-sdk/contributors)

## 联系我们

- 如果需要帮助，请提交工单（在portal右侧点击咨询和建议提交工单，或者直接向 support@qiniu.com 发送邮件）
- 如果有什么问题，可以到问答社区提问，[问答社区](http://free.segmentfault.com/)
- 更详细的文档，见[官方文档站](http://developer.qiniu.com/)
- 如果发现了bug， 欢迎提交 [issue](https://github.com/free/php-sdk/issues)
- 如果有功能需求，欢迎提交 [issue](https://github.com/free/php-sdk/issues)
- 如果要提交代码，欢迎提交 pull request
- 欢迎关注我们的[微信](http://www.qiniu.com/#weixin) [微博](http://weibo.com/freetek)，及时获取动态信息。

## 代码许可

The MIT License (MIT).详情见 [License文件](https://github.com/free/php-sdk/blob/master/LICENSE).

[packagist]: http://packagist.org
[install-packagist]: https://packagist.org/packages/free/php-sdk
