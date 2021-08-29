# Php library for Qvapay API

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ovillafuerte94/qvapay.svg?style=flat)](https://packagist.org/packages/ovillafuerte94/qvapay)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE.md)
![Tests](https://github.com/ovillafuerte94/qvapay/workflows/Tests/badge.svg)
![Check & fix styling](https://img.shields.io/github/workflow/status/ovillafuerte94/qvapay/Check%20&%20fix%20styling?label=code%20style)
[![Total Downloads](https://img.shields.io/packagist/dt/ovillafuerte94/qvapay.svg?style=flat)](https://packagist.org/packages/ovillafuerte94/qvapay)

This PHP library facilitates the integration of the Qvapay API.

## Sign up on QvaPay

Create your account to process payments through QvaPay at [https://qvapay.com/register](https://qvapay.com/register).

### Requirements

- PHP version >= 7.3
- Composer

## Installation

You can install the package via composer:

```bash
composer require ovillafuerte94/qvapay
```

## Usage
- First, import the Client class and create your QvaPay client using your app credentials.

```php
require_once __DIR__ . '/vendor/autoload.php';

use  Qvapay\Client;

$qvapay = new Client([
    'app_id' => 'XXX', 
    'app_secret' => 'XXX',
    'version' => '1'
]);
```

- Get your app info

```php
var_dump($qvapay->info());
```

- Create an invoice

```php
var_dump($qvapay->create_invoice([
    'amount' => 10,
    'description' => 'Ebook',
    'remote_id' => 'EE-BOOk-123' # example remote invoice id
]));
```

- Get transactions

```php
var_dump($qvapay->transactions());
```

- Get transaction

```php
var_dump($qvapay->get_transaction($uuid));
```

- Get your account balance

```php
var_dump($qvapay->balance());
```

You can also read the QvaPay API documentation: [https://qvapay.com/docs](https://qvapay.com/docs).

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Omar Villafuerte](https://github.com/ovillafuerte94)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
