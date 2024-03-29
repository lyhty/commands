<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Convenient Extra Commands
    |--------------------------------------------------------------------------
    |
    | Here you can set the boolean value to each command class to determine
    | whether a command should appear on the artisan command list.
    |
    */

    /**
     * Commands for creating PHP OOP types.
     */
    Lyhty\Commands\AttributeMakeCommand::class => version_compare(PHP_VERSION, '8.0', '>='),
    Lyhty\Commands\ClassMakeCommand::class => true,
    Lyhty\Commands\InterfaceMakeCommand::class => true,
    Lyhty\Commands\TraitMakeCommand::class => true,
    Lyhty\Commands\EnumMakeCommand::class => version_compare(PHP_VERSION, '8.1', '>='),

    /**
     * Commands for Model development.
     */
    Lyhty\Commands\RelationshipMakeCommand::class => true,
    Lyhty\Commands\ScopeMakeCommand::class => true,

    /**
     * Other Commands.
     */
    Lyhty\Commands\ConcernMakeCommand::class => true,
    Lyhty\Commands\ContractMakeCommand::class => true,
    Lyhty\Commands\GeneratorCommandMakeCommand::class => true,

    /**
     * Commands for creating Spatie's QueryBuilder classes.
     */
    Lyhty\Commands\QueryFilterMakeCommand::class => interface_exists('Spatie\QueryBuilder\Sorts\Sort'),
    Lyhty\Commands\QuerySortMakeCommand::class => interface_exists('Spatie\QueryBuilder\Filters\Filter'),
];
