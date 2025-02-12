<?php

namespace App\Http\Livewire;
use App\Models\Ticket;
use Illuminate\Console\View\Components\Component;

class QueueScreen extends Component
{
    public $currentTickets;

    protected $listeners = ['ticketUpdated' => 'refreshData'];

    public function render()
    {
        $this->currentTickets = Ticket::with(['counter', 'service'])
            ->where('status', 'processing')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.queue-screen');
    }

    public function refreshData()
    {
        $this->currentTickets = Ticket::with(['counter', 'service'])
            ->where('status', 'processing')
            ->latest()
            ->take(5)
            ->get();
    }
}