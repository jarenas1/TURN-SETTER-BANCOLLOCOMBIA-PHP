<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Service;

class SelectService extends Component
{
    public $services;
    public $selectedService;
    public $documentNumber;
    public $assignedTicket;

    public function mount()
    {
        $this->services = Service::all();
    }

    public function generateTicket()
    {
        $this->validate([
            'selectedService' => 'required|exists:services,id',
            'documentNumber' => 'required|numeric'
        ]);

        // Lógica para generar el ticket (usando TicketService)
        $this->assignedTicket = '001'; // Temporal para el diseño
    }

    public function render()
    {
        return view('livewire.select-service');
    }
}