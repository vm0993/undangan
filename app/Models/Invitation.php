<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $guarded = array();

    public function tamu()
    {
        return $this->belongsTo(Guest::class);
    }
}
