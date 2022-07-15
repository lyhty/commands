<p align="center">
    <img src="https://matti.suoraniemi.com/storage/forur.png" width="400">
</p>

<p align="center">
    <a href="https://packagist.org/packages/sirmathays/convenient-laravel-commands">
        <img src="https://img.shields.io/packagist/dt/sirmathays/convenient-laravel-commands" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/sirmathays/convenient-laravel-commands">
        <img src="https://img.shields.io/packagist/v/sirmathays/convenient-laravel-commands" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/sirmathays/convenient-laravel-commands">
        <img src="https://img.shields.io/packagist/l/sirmathays/convenient-laravel-commands" alt="License">
    </a>
</p>

This package provides some additional, convenient commands for you to use with your Laravel project.

## Installation

Install the package with Composer:

    composer require sirmathays/convenient-laravel-commands

## Commands

Here's a brief documentation on the make commands the package provides to be used with Artisan.

### Commands for creating PHP OOP types

    artisan make:class --type[=TYPE] <name>

> Valid type options: final, abstract.

    artisan make:interface <name>
    artisan make:trait <name>

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

Convenient Laravel Commands is open-sourced software licensed under the [MIT license](LICENSE.md).
