<p>
    <img src="https://matti.suoraniemi.com/storage/lyhty-commands.png" width="400">
</p>

[![Latest Stable Version](https://img.shields.io/packagist/v/lyhty/commands?label=&logo=packagist&logoColor=white&style=flat-square)](https://packagist.org/packages/lyhty/commands)
[![PHP](https://img.shields.io/packagist/php-v/lyhty/commands?style=flat-square&label=&logo=php&logoColor=white)](https://packagist.org/packages/lyhty/commands)
[![Laravel](https://img.shields.io/static/v1?label=&message=^11%20|%20^12&color=red&style=flat-square&logo=laravel&logoColor=white)](https://packagist.org/packages/lyhty/co^mands)
[![Total Downloads](https://img.shields.io/packagist/dt/lyhty/commands?style=flat-square)](https://packagist.org/packages/lyhty/commands)
[![License](https://img.shields.io/packagist/l/lyhty/commands?style=flat-square)](https://packagist.org/packages/lyhty/commands)

<!-- CUTOFF -->

This package provides some additional, convenient commands for you to use with your Laravel project.

## Installation

Install the package with Composer:

    composer require lyhty/commands

## Commands

Here's a brief documentation on the make commands the package provides to be used with Artisan.

### Commands for creating PHP OOP types

    artisan make:class --type[=TYPE] <name>

> Valid values for option `type`: `final`, `abstract`.

    artisan make:attribute --type[=TYPE] --target[=TARGET] <name>

> Same valid values for option `type` as in `make:class`
>
> Valid values for option `target`: `class`, `function`, `method`, `property`, `class_constant`, `parameter`, `all`

    artisan make:interface <name>
    artisan make:trait <name>
    artisan make:enum --backed[=BACKED] <name>

### Commands for Model development

#### Relationship trait

    artisan make:relationship --explicit --relation[=RELATION] --model[=MODEL] <name>

Creates a relationship trait to be used with models. The command tries to guess both the relation and the model class from the `name` argument. Both can be overwritten by providing options for each. By adding the `explicit` option, parsing will not be used and options for both `model` and `relation` must be provided.

#### Scope class

    artisan make:scope --extend <name>

Creates a scope class to be used with models. Defaults to the namespace the project's models exist in (e.g. App\Models\Scopes). When using `extend` option, the class will also include `extend` function, used to apply Builder macros to the model the scope is attached to as a global scope.

### Commands for creating classes for Spatie's QueryBuilder _(if part of the project)_

    artisan make:query-filter <name>
    artisan make:query-sort <name>

### Other Commands

#### Concern trait

    artisan make:concern <name>

Creates a concern trait. It's practically a trait that just follows the Laravel naming conventions. Defaults to the root namespace of the project (e.g. App\Concerns).

#### Contract trait

    artisan make:contract <name>

Creates a contract interface. It's practically an interface that just follows the Laravel naming conventions. Defaults to the root namespace of the project (e.g. App\Contracts).

#### Generator Command class

    artisan make:command-gen --explicit --type[=TYPE] --stub[=STUB] <name>

Creates a generator command and a stub. Command parses the type name from the given name argument. E.g. `artisan make:command-gen ConcernMakeCommand` would set the command name to be `make:concern` and the stub file to be named `concern.stub`. This behavior can be overwritten with using the `explicit` option and/or providing `type` and `stub` options respectively.

## License

Lyhty Commands is open-sourced software licensed under the [MIT license](LICENSE.md).
