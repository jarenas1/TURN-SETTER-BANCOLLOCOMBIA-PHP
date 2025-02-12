<?php

use App\Models\Service;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class TicketService
{
    public function generateTicket(Service $service, ?string $citizenId): Ticket
    {
        return DB::transaction(function () use ($service, $citizenId) {
            $lastTicket = $service->tickets()
                ->whereDate('created_at', today())
                ->latest()
                ->first();

            $number = $lastTicket ? (int) substr($lastTicket->number, 1) + 1 : 1;
            $ticketNumber = $service->prefix . str_pad($number, 3, '0', STR_PAD_LEFT);

            return $service->tickets()->create([
                'number' => $ticketNumber,
                'citizen_id' => $citizenId,
            ]);
        });
    }
}