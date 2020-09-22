# Changelog

## 3.0.0 - TBD

### Added

- Nothing.

### Changed

- Configuration was changed to use `Doctrine\ODM\MongoDB\Configuration:AUTOGENERATE_*` constants instead of removed `AbstractProxyFactory::AUTOGENERATE_*`. If you override those settings in your local config, ensure the proper constants are used.
- Adapt to `doctrine/peristence:2.0`
- add return types to `\DoctrineMongoODMModule\Logging\Logger` implementations
- `DoctrineMongoODMModule\Options\Configuration::getGenerateHydrators()` returns an `int` instead of a `bool`
- `DoctrineMongoODMModule\Options\Configuration::setGenerateHydrators()` requires an `int` instead of a `bool` for its first parameter
- `DoctrineMongoODMModule\Options\Configuration`: The methods `getPersistentCollectionFactory` and `getPersistentCollectionGenerator` can now return `null`.

### Deprecated

- Nothing.

### Removed

- `DoctrineMongoODMModule\Paginator\Adapter\DoctrinePaginator` was removed because `Doctrine\ODM\MongoDB\Cursor` doesn't exist anymore and there is no simple workaround.
- The CLI commands `odm:generate:documents` and `odm:generate:repositories` were removed because they no longer exist.

### Fixed

- Nothing.

## 2.0.0 - 2020-04-06

- Drop PHP 7.1 support.
- Add Laminas support.

## 1.1.0

- [#206](https://github.com/docrine/DoctrineMongoODMModule/pull/206) Drop PHP 5.6 and 7.0 support
- [#206](https://github.com/docrine/DoctrineMongoODMModule/pull/206) Add PHP 7.3 support
- [#206](https://github.com/docrine/DoctrineMongoODMModule/pull/206) Add DoctrineModule ^2.1 support, while retaining compatibility with previous version

## 1.0.0

- [#159](https://github.com/docrine/DoctrineMongoODMModule/pull/159) Add support for hydrator and proxy generation strategies
- [#178](https://github.com/docrine/DoctrineMongoODMModule/pull/178) Make code examples PHP 7 compatible
- [#177](https://github.com/docrine/DoctrineMongoODMModule/pull/177) Injecting event manager to allow listeners to trigger correctly
- [#176](https://github.com/docrine/DoctrineMongoODMModule/pull/176) Allow configuration of repository factory
- [#181](https://github.com/docrine/DoctrineMongoODMModule/pull/181) Custom collection support
- [#182](https://github.com/docrine/DoctrineMongoODMModule/pull/182) Test PHP 7.1 on travis
- [#184](https://github.com/docrine/DoctrineMongoODMModule/pull/184) Code cleanup

## 0.11.0

- [#161](https://github.com/docrine/DoctrineMongoODMModule/pull/161) Add PHP 7 to the build matrix
- [#168](https://github.com/docrine/DoctrineMongoODMModule/pull/168) ZF3 compatibility
- [#172](https://github.com/docrine/DoctrineMongoODMModule/pull/172) Require stable version of DoctrineModule 1.2.0 instead of dev-master

## 0.10.0

- [#146](https://github.com/doctrine/DoctrineMongoODMModule/pull/146) Support for `odm:schema:update` command
- [#153](https://github.com/doctrine/DoctrineMongoODMModule/pull/153) Update to stable package versions
- [#133](https://github.com/doctrine/DoctrineMongoODMModule/pull/133) Allows null value as DefaultDb
- [#155](https://github.com/doctrine/DoctrineMongoODMModule/pull/155) Fix pagination count with eager cursors
- [#156](https://github.com/doctrine/DoctrineMongoODMModule/pull/156) Remove support for old PHP versions
- [#160](https://github.com/doctrine/DoctrineMongoODMModule/pull/160) Fixed Zend\Mvc 2.7 compatibility

## 0.9.1
- [#140](https://github.com/doctrine/DoctrineMongoODMModule/pull/140) Fixed #139 add minimum stabiliy dev for mongodb-odm

## 0.9.0
- [#125](https://github.com/doctrine/DoctrineMongoODMModule/pull/125) Drop PHP 5.3 support
- [#124](https://github.com/doctrine/DoctrineMongoODMModule/pull/124) Add DoctrineObject factory for DocumentManager
- [#128](https://github.com/doctrine/DoctrineMongoODMModule/pull/128) allow adding custom types via module config
- [#135](https://github.com/doctrine/DoctrineMongoODMModule/pull/135) Stable composer configuration

## 0.8.2

- [#108](https://github.com/doctrine/DoctrineMongoODMModule/pull/108) updated paginator documentation
- [#108](https://github.com/doctrine/DoctrineMongoODMModule/pull/109) added user guide
- [#114](https://github.com/doctrine/DoctrineMongoODMModule/pull/114) simplified unit testing
- [#115](https://github.com/doctrine/DoctrineMongoODMModule/pull/115) removed files for old test setup
