<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;


class Service extends Model
{
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}