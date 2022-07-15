<?php

namespace Lyhty\Commands\Relationship;

use Illuminate\Database\Eloquent\Relations\MorphMany;

class MorphManyBridge extends RelationBridge
{
    protected static $relationClassName = MorphMany::class;

    public static $stubGroupAffix = 'morph';
}
