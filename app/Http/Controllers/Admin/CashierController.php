<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $currentTicket = Ticket::with('service')
            ->where('counter_id', $user->counter->id)
            ->where('status', 'processing')
            ->first();

        $pendingTickets = Ticket::with('service')
            ->where('status', 'pending')
            ->oldest()
            ->take(5)
            ->get();

        return view('cashier.dashboard', [
            'currentTicket' => $currentTicket,
            'pendingTickets' => $pendingTickets
        ]);
    }

    public function nextTicket()
    {
        $user = Auth::user();
        
        if (!$user->counter) {
            return back()->with('error', 'No tienes taquilla asignada');
        }

        // Finalizar ticket actual
        Ticket::where('counter_id', $user->counter->id)
            ->where('status', 'processing')
            ->update(['status' => 'completed']);

        // Asignar nuevo ticket
        $nextTicket = Ticket::where('status', 'pending')
            ->oldest()
            ->first();

        if ($nextTicket) {
            $nextTicket->update([
                'status' => 'processing',
                'counter_id' => $user->counter->id
            ]);
        }

        return back()->with('success', 'Turno actualizado');
    }
}
