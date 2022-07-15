<?php

namespace Lyhty\Commands\Relationship;

use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class HasOneThroughBridge extends RelationBridge
{
    protected static $relationClassName = HasOneThrough::class;

    protected static $returnsCollection = false;

    protected static $modelCount = 2;

    public static $stubGroupAffix = 'has-through';
}
