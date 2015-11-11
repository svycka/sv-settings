# svycka/sv-settings

[![Build Status][ico-travis]][link-travis]
[![Coverage Status](https://coveralls.io/repos/svycka/sv-settings/badge.svg?branch=master&service=github)](https://coveralls.io/github/svycka/sv-settings?branch=master)
[![Quality Score][ico-code-quality]][link-code-quality]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

This module simplifies settings storage. For example this can be used with [ZfcUser](https://github.com/ZF-Commons/ZfcUser) or store your application global settings. This module also could be used with CMS to store page settings like title, description, SEO, published time or whatever you want. This module also provides optional simple REST API to change your settings.

## Install

Via Composer

``` bash
$ composer require svycka/sv-settings
```

## Basic Usage

- Register `Svycka/Settings` as module in `config/application.config.php`
- Copy the file located in `vendor/svycka/sv-settings/config/settings.global.php.dist` to `config/autoload/settings.global.php` and change the values as you wish

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Credits

- [Vytautas Stankus][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/svycka/sv-settings.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/svycka/sv-settings/master.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/svycka/sv-settings.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/svycka/sv-settings.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/svycka/sv-settings
[link-downloads]: https://packagist.org/packages/svycka/sv-settings
[link-travis]: https://travis-ci.org/svycka/sv-settings
[link-code-quality]: https://scrutinizer-ci.com/g/svycka/sv-settings
[link-author]: https://github.com/svycka
[link-contributors]: ../../contributors
