<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service; // ← Importación necesaria
use App\Models\Counter; // ← Importación necesaria

class Ticket extends Model
{
    // Relación con Service
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Relación con Counter
    public function counter()
    {
        return $this->belongsTo(Counter::class);
    }
}