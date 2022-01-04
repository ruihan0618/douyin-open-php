# douyin-open-php

You can sign up for a MasJPay account at https://www.visionrhythm.com/.

## Requirements

PHP 5.6.0 and later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require vision-rhythm/douyin-open-php
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/chuangxiangjpay/jpay-php/releases). Then, to use the bindings, include the `init.php` file.

```php
require_once('/path/to/douyin-open-php/init.php');
```

## Dependencies

The bindings require the following extensions in order to work properly:

- [`curl`](https://secure.php.net/manual/en/book.curl.php), although you can use your own non-cURL client if you prefer
- [`json`](https://secure.php.net/manual/en/book.json.php)
- [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) (Multibyte String)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.

## Getting Started

Simple usage looks like:

```php
const CLIENT_ID = '';
const CLIENT_SECRET = '';

\Visionrhythm\VisionRhythm::setDebug(true); //调试模式   true /false
\Visionrhythm\VisionRhythm::setApiMode('sandbox'); //环境  live 线上，sandbox 沙盒
\Visionrhythm\VisionRhythm::setclientId(CLIENT_ID);    // 设置 id
\Visionrhythm\VisionRhythm::setclientSecret(CLIENT_SECRET);   // secret
\VisionRhythm\VisionRhythm::setRedirectUri(''); //回调地址


$open_id = '';
$access_token = '';

try {

    $userInfo = \VisionRhythm\User::info($open_id, $access_token);
    echo($userInfo)."\r\n";

    $fans = \VisionRhythm\User::fans($open_id, $access_token, 0, 10);
    echo($fans)."\r\n";

    $following = \VisionRhythm\User::following($open_id, $access_token, 0, 10);
    echo($following)."\r\n";

} catch (\Visionrhythm\Error\Base $e) {
    if ($e->getHttpStatus() != null) {
        header('Status: ' . $e->getHttpStatus());
        echo $e->getHttpBody();
    } else {
        echo $e->getMessage();
    }
}



```

## Development

Get [Composer][composer]. For example, on Mac OS:

```bash
brew install composer
```

Install dependencies:

```bash
composer install
```

Install dependencies as mentioned above (which will resolve [PHPUnit](http://packagist.org/packages/phpunit/phpunit)), then you can run the test suite:

```bash
./vendor/bin/phpunit
```

Or to run an individual test file:

```bash
./vendor/bin/phpunit tests/UtilTest.php
```

The method should be called once, before any request is sent to the API. The second and third parameters are optional.