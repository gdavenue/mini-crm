<?php

namespace App\Actions;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use Carbon\Carbon;

class UpdateTicketStatus
{
	public function handle(Ticket $ticket, string $status): Ticket
	{
		$ticket->status = $status;
		$ticket->answered_at = $status === TicketStatus::Resolved->value ? Carbon::now() : $ticket->answered_at;
		$ticket->save();

		return $ticket->refresh();
	}
}
