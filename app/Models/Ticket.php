<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service; 
use App\Models\Counter; 

class Ticket extends Model
{
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }
}