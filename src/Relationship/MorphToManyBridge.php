<?php

namespace Lyhty\Commands\Relationship;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

class MorphToManyBridge extends RelationBridge
{
    protected static $relationClassName = MorphToMany::class;

    public static $stubGroupAffix = 'morph';
}
