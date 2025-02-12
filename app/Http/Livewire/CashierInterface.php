<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class CashierInterface extends Component
{
    public $currentTicket;
    public $citizenName;
    
    public function nextTicket()
    {
        $counter = Auth::user()->counter;
        
        $ticket = Ticket::where('counter_id', $counter->id)
            ->where('status', 'processing')
            ->first();

        if ($ticket) {
            $ticket->update(['status' => 'completed']);
        }

        $nextTicket = Ticket::where('status', 'pending')
            ->oldest()
            ->first();

        if ($nextTicket) {
            $nextTicket->update([
                'status' => 'processing',
                'counter_id' => $counter->id
            ]);
            $this->currentTicket = $nextTicket;
            $this->emit('ticketUpdated');
        }
    }
}