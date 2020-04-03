# Omnipay: Bankart

**Bankart v2 (2020) driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Dummy support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "datalinx/omnipay-bankart": "@dev"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

* Bankart

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Supported operations
* Authorization
* Capture
* Void
* Refund

## Available languages
To select a language for the Hosted Payment Page, pass the "language" parameter to the Authorization requests:

* sl (Slovenian)
* en (English)
* de (German)
* me (Montenegrin)
* mk (Macedonian)

## Test cards

* 4111 1111 1111 1111 - Visa (succeeds)
* 4242 4242 4242 4242 - Visa (fails)
* 5555 5555 5555 4444 - Mastercard (succeeds)
* 5105 1051 0510 5100 - Mastercard (fails)

## Reference
* [Bankart backoffice](https://gateway.bankart.si/)
* [Bankart Gateway documentation](https://gateway.bankart.si/documentation/gateway)
* [API reference](https://gateway.bankart.si/documentation/api)

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/thephpleague/omnipay-dummy/issues),
or better yet, fork the library and submit a pull request.
