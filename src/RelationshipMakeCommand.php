<?php

namespace Lyhty\Commands;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Lyhty\Commands\Relationship\RelationBridge;
use Symfony\Component\Console\Input\InputOption;

class RelationshipMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:relationship';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new relationship trait';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Relationship';

    /**
     * Supported relation bridges.
     *
     * @var array
     */
    protected static $relationBridges = [
        Relationship\BelongsToManyBridge::class,
        Relationship\BelongsToBridge::class,
        Relationship\HasManyThroughBridge::class,
        Relationship\HasManyBridge::class,
        Relationship\HasOneThroughBridge::class,
        Relationship\HasOneBridge::class,
        Relationship\MorphedByManyBridge::class,
        Relationship\MorphToManyBridge::class,
        Relationship\MorphManyBridge::class,
        Relationship\MorphOneBridge::class,
    ];

    /**
     * Relation bridge for the relationship generation.
     *
     * @var RelationBridge
     */
    protected $bridge;

    /**
     * {@inheritDoc}
     */
    public function handle()
    {
        $explicit = $this->option('explicit');
        $errorText = 'Both relation and model(s) must be provided when using explicit mode!';

        // If explicit mode is used but relation or model is not given as options.
        if ($explicit && (! $this->option('relation') || ! $this->option('model'))) {
            $this->error($errorText);

            return false;
        }

        if ($this->setBridge() === false) {
            $this->error('Invalid relationship name given!');

            return false;
        }

        // If explicit mode is used but seond model is not given as an option and the relation requires it.
        if ($this->bridge->getModelCount() > 1 && $explicit && ! $this->option('second-model')) {
            $this->error($errorText);

            return false;
        }

        if (parent::handle() === false) {
            return false;
        }
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        return $this->replaceStubVariables($stub);
    }

    /**
     * Get model name.
     *
     * @return string
     */
    public function getModel(string $choice = null): string
    {
        $option = 'model';

        if (! in_array($choice, $which = [null, 'second'])) {
            $choice = null;
        }

        if (! is_null($choice)) {
            $option = "{$choice}-{$option}";
        }

        return Str::of(
            $this->option($option) ??
                Arr::get(
                    $this->bridge->getModelsFromName($this->getNameInput()),
                    array_search($choice, $which)
                )
        )->singular()->studly();
    }

    /**
     * Get qualified model name.
     *
     * @param  string  $choice
     * @return string
     */
    public function getQualifiedModel(string $choice = null): string
    {
        if (is_null($model = $this->getModel($choice))) {
            return '';
        }

        return Str::startsWith($model, '\\')
            ? trim($model, '\\')
            : $this->qualifyModel($model);
    }

    /**
     * Get the basename of the qualified model.
     *
     * @param  string  $choice
     * @return string
     */
    public function getModelBasename(string $choice = null): string
    {
        return class_basename($this->getQualifiedModel($choice));
    }

    /**
     * Replace the model for the given stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function replaceStubVariables($stub)
    {
        $bridge = $this->bridge;

        $model = $this->getModelBasename();
        $namespacedModel = $this->getQualifiedModel();
        $modelStr = Str::of($model);

        $relName = $bridge->getNameAsStr();
        $relCount = $bridge->getCount();

        $namespacedRelationshipInstanceClass = $bridge->returnsCollection()
            ? '\\'.Collection::class."<\\$namespacedModel>"
            : "\\$namespacedModel";

        $relationshipString = $modelStr->singular()->snake(' ');

        $replace = [
            '{{ model }}' => $model,
            '{{ namespacedModel }}' => $namespacedModel,
            '{{ relationMethod }}' => $relName->camel(),
            '{{ relationClass }}' => $bridge->getRelationClassName(),
            '{{ namespacedRelationClass }}' => $bridge->getRelationClassName(false),
            '{{ namespacedRelationshipInstanceClass }}' => $namespacedRelationshipInstanceClass,
            '{{ snakeUpperCaseClassName }}' => Str::of($this->getNameInput())->snake()->upper(),
            '{{ relationship }}' => $modelStr->camel()->plural($relCount),
            '{{ foreignKeyPrefix }}' => $modelStr->snake()->singular(),
            '{{ ucRelationship }}' => ucfirst($modelStr),
            '{{ relationshipString }}' => $relationshipString,
            '{{ relationshipLongString }}' => $relationshipString
                ->start($relCount <= 1 ? 'the ' : '')
                ->finish(' '.Str::plural('relationship', $relCount)),
        ];

        if ($this->bridge->getModelCount() > 1) {
            $replace = array_merge($replace, [
                '{{ secondModel }}' => $this->getModelBasename('second'),
                '{{ namespacedSecondModel }}' => $this->getQualifiedModel('second'),
            ]);
        }

        $stub = str_replace(
            array_keys($replace),
            array_values($replace),
            $stub
        );

        return str_replace(
            "use {$namespacedModel};\nuse {$namespacedModel};",
            "use {$namespacedModel};",
            $stub
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $this->getDefaultModelNamespace($rootNamespace)
            .'\\Relationships';
    }

    /**
     * {@inheritDoc}
     */
    protected function getStub()
    {
        if (file_exists($specialStub = $this->resolveStubPath('/stubs/'.$this->bridge::getSpecialStubName()))) {
            return $specialStub;
        }

        return $this->resolveStubPath('/stubs/'.$this->bridge::getStubName());
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['explicit', 'e', InputOption::VALUE_NONE, 'Skip implicit model and relation binding'],
            ['model', null, InputOption::VALUE_OPTIONAL, 'The model that the relationship is based on'],
            ['second-model', null, InputOption::VALUE_OPTIONAL, 'The second model that the relationship uses, if necessary'],
            ['relation', null, InputOption::VALUE_OPTIONAL, 'The relation that the relationship is based on'],
        ];
    }

    /**
     * Set relation bridge.
     *
     * @return bool
     */
    protected function setBridge(): bool
    {
        foreach (self::$relationBridges as $bridgeClass) {
            if ($this->option('relation')) {
                if ($this->option('relation') == $bridgeClass::getName()) {
                    $this->bridge = new $bridgeClass;
                    break;
                }
            } elseif ($bridgeClass::matchesRelationshipName($this->getNameInput())) {
                $this->bridge = new $bridgeClass;
                break;
            }
        }

        return $this->bridge instanceof RelationBridge;
    }
}
