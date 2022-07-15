<?php

namespace Lyhty\Commands;

class InterfaceMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:interface';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new PHP interface';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Interface';
}
