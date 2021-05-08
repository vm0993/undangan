<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $guarded = array();

    public function tamu()
    {
        return $this->belongsTo('\App\Models\Guest','guest_id','id');
    }

    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }
}
