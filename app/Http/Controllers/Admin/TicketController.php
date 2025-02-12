<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Service;
use App\Models\Counter;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['service', 'counter'])
            ->orderBy('created_at', 'desc')
            ->paginate(25);
            
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        return view('admin.tickets.show', compact('ticket'));
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return back()->with('success', 'Ticket eliminado');
    }
}
