<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;

class Counter extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}