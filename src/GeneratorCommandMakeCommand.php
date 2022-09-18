<?php

namespace Lyhty\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GeneratorCommandMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:command-gen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Artisan generator command';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Console generator command';

    /**
     * {@inheritDoc}
     */
    public function handle()
    {
        if ($this->option('explicit') && ! $this->option('type')) {
            $this->error('Type option must be provided when using explicit mode!');

            return false;
        }

        if ((! $this->hasOption('force') ||
            ! $this->option('force')) &&
            $this->stubAlreadyExists()
        ) {
            $this->error('Stub for '.lcfirst($this->type).' already exists!');

            return false;
        }

        $path = $this->getStubPath();

        if (parent::handle() === false) {
            return false;
        }

        // Create stub for generator.
        $this->makeDirectory($path);

        $this->files->put($path, "<?php\n\nnamespace {{ namespace }};\n\nclass {{ class }}\n{\n\t//\n}");

        $this->info('Stub for '.lcfirst($this->type).' created successfully.');
    }

    /**
     * Get the type option or guess from inputted name.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->option('type')
            ?? Str::of($this->getNameInput())->beforeLast('Make')->kebab();
    }

    /**
     * Determine if the stub already exists.
     *
     * @return bool
     */
    protected function stubAlreadyExists()
    {
        return $this->files->exists($this->getStubPath());
    }

    /**
     * Return the stub's name.
     *
     * @return string
     */
    public function getStubName(): string
    {
        return $this->option('stub')
            ?? Str::kebab($this->getType());
    }

    /**
     * Return the stub path.
     *
     * @return string
     */
    public function getStubPath()
    {
        return $this->laravel->basePath('stubs/'.$this->getStubName().'.stub');
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        $type = Str::of($this->getType());

        $replace = [
            '{{ typeKebab }}' => $type->kebab(),
            '{{ typeString }}' => $str = $type->snake(' '),
            '{{ typeUcString }}' => $str->ucfirst(),
            '{{ typeStudly }}' => $studly = $type->studly(),
            '{{ typeStudlyPlural }}' => $studly->plural(),
            '{{ stubName }}' => $this->getStubName(),
        ];

        return str_replace(
            array_keys($replace),
            array_values($replace),
            $stub
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $relativePath = '/stubs/generator.stub';

        return file_exists($customPath = $this->laravel->basePath(trim($relativePath, '/')))
            ? $customPath
            : __DIR__.'/../'.$relativePath;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\Console\\Commands';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the command'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['explicit', 'e', InputOption::VALUE_NONE, 'Skip implicit type and stub binding'],
            ['type', null, InputOption::VALUE_OPTIONAL, 'The name of the type that the command will generate'],
            ['stub', null, InputOption::VALUE_OPTIONAL, 'The name of the stub that the command will generate'],
        ];
    }
}
