<?php

namespace Lyhty\Commands\Relationship;

use Illuminate\Database\Eloquent\Relations\HasOne;

class HasOneBridge extends RelationBridge
{
    protected static $relationClassName = HasOne::class;

    protected static $returnsCollection = false;
}
