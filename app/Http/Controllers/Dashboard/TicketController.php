<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterTicketRequest;
use App\Http\Requests\UpdateTicketStatusRequest;
use App\Actions\GetTicketList;
use App\Actions\GetTicketStatistics;
use App\Actions\UpdateTicketStatus;
use App\Models\Ticket;

class TicketController extends Controller
{
	public function index(FilterTicketRequest $request, GetTicketList $list, GetTicketStatistics $stats)
	{
		$filters = $request->validated();
		$tickets = $list->handle($filters);
		$stats = $stats->handle();

		return view('dashboard.tickets.index', compact('tickets', 'filters', 'stats'));
	}

	public function show(Ticket $ticket)
	{
		$ticket->load(['customer', 'media']);

		return view('dashboard.tickets.show', compact('ticket'));
	}

	public function updateStatus(UpdateTicketStatusRequest $request, Ticket $ticket, UpdateTicketStatus $update)
	{
		$ticket = $update->handle($ticket, $request->validated()['status']);

		return back()->with('success', __('Status successfully updated.'));
	}
}
