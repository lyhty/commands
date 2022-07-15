<?php

namespace Lyhty\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ScopeMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:scope';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new scope class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Scope';

    /**
     * {@inheritDoc}
     */
    protected function getStubPath(): string
    {
        $path = parent::getStubPath();

        if ($this->option('extend') === true) {
            $path = Str::replaceLast('.', '.extend.', $path);
        }

        return $path;
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $this->getDefaultModelNamespace($rootNamespace)
            .'\\Scopes';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['extend', 'e', InputOption::VALUE_NONE, 'Adds query builder extension logic to the class'],
        ];
    }
}
