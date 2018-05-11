<?php

namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * App\Model
 *
 * @mixin \Eloquent
 */
class Model extends EloquentModel
{
    protected $guarded = [];
}
