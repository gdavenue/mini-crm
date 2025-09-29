<?php

namespace App\Actions;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetTicketList
{
	public function handle(array $filters = []): LengthAwarePaginator
	{
		$query = Ticket::with(['customer', 'media']);

		$from = !empty($filters['from']) ? Carbon::parse($filters['from']) : null;
		$to = !empty($filters['to']) ? Carbon::parse($filters['to'])->endOfDay() : null;
		$query->createdBetween($from, $to);

		$query->status($filters['status'] ?? null);
		$query->customerEmail($filters['email'] ?? null);
		$query->customerPhone($filters['phone'] ?? null);

		$perPage = $filters['per_page'] ?? 15;

		return $query->orderByDesc('created_at')->paginate($perPage);
	}
}
