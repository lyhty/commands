<?php

namespace Lyhty\Commands\Relationship;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BelongsToBridge extends RelationBridge
{
    protected static $relationClassName = BelongsTo::class;

    protected static $returnsCollection = false;
}
