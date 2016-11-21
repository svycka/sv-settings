# Changelog

All Notable changes to `svycka/sv-settings` will be documented in this file

## 2.0.0 - 2016-11-21

### Added
- Updated dependencies to `zendframework/zend-servicemanager:3.1.1`, `zendframework/zend-stdlib:3.1`, `doctrine/doctrine-orm-module:1.1`.

### Deprecated
- Nothing

### Fixed
- Removed https://github.com/zendframework/zend-mvc/pull/43 workaround in controller because it is fixed since `zendframework/zend-mvc:2.7.2`

### Removed
- Dropped support for `PHP 5.5`, `zendframework/zend-servicemanager:2.*`, `zendframework/zend-stdlib:2.*` and `doctrine/doctrine-orm-module:0.*`.
- [BC Break] Removed deprecated setting type `in_array` alias. Use: `inarray` or `Svycka\Settings\Type\InArrayType::class`.
- [BC Break] Removed ZfcUser support because it does not yet support `zendframework/zend-servicemanager:3.1.1` and also is pretty easy to create this provider.

### Security
- Nothing

## 1.0.0 - 2016-02-24

Initial release.
