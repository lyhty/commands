<?php

namespace Lyhty\Commands\Relationship;

use Illuminate\Database\Eloquent\Relations\HasMany;

class HasManyBridge extends RelationBridge
{
    protected static $relationClassName = HasMany::class;
}
