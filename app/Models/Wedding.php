<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wedding extends Model
{
    protected $guarded = array();

    public function undangan()
    {
        return $this->belongsTo(Invitation::class);
    }
}
