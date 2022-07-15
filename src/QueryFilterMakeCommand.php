<?php

namespace Lyhty\Commands;

class QueryFilterMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:query-filter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Filter class for Spatie QueryBuilder';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Query Filter';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\Queries\\Filters';
    }
}
