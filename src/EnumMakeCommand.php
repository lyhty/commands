<?php

namespace Lyhty\Commands;

use Symfony\Component\Console\Input\InputOption;

class EnumMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:enum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new PHP enum';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Enum';

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        return $this->replaceBackedEnumType(
            parent::buildClass($name)
        );
    }

    /**
     * Replace the model for the given stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function replaceBackedEnumType($stub)
    {
        $typeOption = $this->option('backed');

        $replace = [
            '{{ enumType }}' => $typeOption ? ": $typeOption" : '',
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
            ['backed', 'b', InputOption::VALUE_OPTIONAL, 'Make a backed enum with given type.'],
        ];
    }
}
