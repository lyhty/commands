<?php

namespace Lyhty\Commands;

class QuerySortMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:query-sort';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Sort class for Spatie QueryBuilder';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Query Sort';

    /**
     * {@inheritDoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\Queries\\Sorts';
    }
}
