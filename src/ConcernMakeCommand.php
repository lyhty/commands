<?php

namespace Lyhty\Commands;

class ConcernMakeCommand extends TraitMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:concern';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Concern trait';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Concern';

    /**
     * {@inheritDoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\Concerns';
    }
}
