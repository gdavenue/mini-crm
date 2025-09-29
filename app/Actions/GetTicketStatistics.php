<?php

namespace App\Actions;

use App\Models\Ticket;
use Carbon\Carbon;

class GetTicketStatistics
{
	public function handle(): array
	{
		$now = Carbon::now();

		$dayCount = Ticket::where('created_at', '>=', $now->copy()->subDay())->count();
		$weekCount = Ticket::where('created_at', '>=', $now->copy()->subWeek())->count();
		$monthCount = Ticket::where('created_at', '>=', $now->copy()->subMonth())->count();

		return [
			'day' => $dayCount,
			'week' => $weekCount,
			'month' => $monthCount,
		];
	}
}
