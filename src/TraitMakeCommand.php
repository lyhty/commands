<?php

namespace Lyhty\Commands;

class TraitMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:trait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new PHP trait';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Trait';
}
