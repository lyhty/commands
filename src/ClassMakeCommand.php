<?php

namespace Lyhty\Commands;

use Symfony\Component\Console\Input\InputOption;

class ClassMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:class';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new PHP class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Class';

    /**
     * Supported class types.
     *
     * @var array
     */
    protected $classTypes = [
        'final', 'abstract', null,
    ];

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        return $this->replaceClassType(
            parent::buildClass($name)
        );
    }

    /**
     * Replace the model for the given stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function replaceClassType($stub)
    {
        $typeOption = $this->option('type');
        $classType = in_array($typeOption, $this->classTypes) && is_string($typeOption)
            ? "$typeOption "
            : '';

        $replace = [
            '{{ classType }}' => $classType.'class',
        ];

        return str_replace(
            array_keys($replace),
            array_values($replace),
            $stub
        );
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['type', null, InputOption::VALUE_OPTIONAL, 'Define class type: final/abstract.'],
        ];
    }
}
