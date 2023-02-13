<?php

namespace Lyhty\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class AttributeMakeCommand extends ClassMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:attribute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new PHP attribute';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Attribute';

    /**
     * Replace the model for the given stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function replaceClassType($stub)
    {
        $stub = parent::replaceClassType($stub);

        if (! is_string($targetOption = $this->option('target'))) {
            $targetOption = 'all';
        }

        $target = (string) Str::of($targetOption)->snake()->upper()->start('TARGET_');

        $replace = [
            '{{ attributeTarget }}' => $target,
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
        return array_merge(
            parent::getOptions(),
            ['target', null, InputOption::VALUE_OPTIONAL, 'Define attribute target: class/function/method/property/class_constant/parameter/all']
        );
    }
}
