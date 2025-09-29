<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Actions\CreateTicket;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
	public function store(StoreTicketRequest $request, CreateTicket $create): JsonResponse
	{
		$ticket = $create->handle($request->validated());

		return response()->json([
			'message' => __('Your application has been sent successfully!'),
			'ticket_id' => $ticket->id,
		], 201);
	}
}
