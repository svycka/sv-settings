# Changelog

All Notable changes to `svycka/sv-settings` will be documented in this file

## 4.1.0 - 2022-07-01

### Added
- Added PHP 8 support and migrated to github actions

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- Nothing

### Security
- Nothing

## 4.0.0 - 2020-09-18

### Added
- Nothing

### Deprecated
- Nothing

### Fixed
- [BC Break] Will call flush() on Doctrine entityManager without specific entity because it is deprecated.

### Removed
- Nothing

### Security
- Nothing

## 3.0.1 - 2020-01-13

### Added
- Nothing

### Deprecated
- Nothing

### Fixed
- Move PHPUnit to dev dependencies

### Removed
- Nothing

### Security
- Nothing

## 3.0.0 - 2020-01-10

### Added
- Added Laminas support
- Added PHP 7.3 and PHP 7.4 support

### Deprecated
- Nothing

### Fixed
- Nothing

### Removed
- [BC Break] Removed Zend Framework support(just renamed to Laminas)
- Removed PHP 5.6, 7.0 and 7.1 support

### Security
- Nothing

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
