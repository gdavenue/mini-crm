<?php

namespace App\Actions;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class CreateTicket
{
	public function handle(array $data): Ticket
	{
		return DB::transaction(function () use ($data) {
			$customer = Customer::firstOrCreate(
				['email' => $data['email']],
				['name' => $data['name'], 'phone' => $data['phone']]
			);

			$ticket = $customer->tickets()->create([
				'subject' => $data['subject'],
				'body' => $data['body'],
				'status' => 'new',
			]);

			if (!empty($data['files']) && is_array($data['files'])) {
				foreach ($data['files'] as $file) {
					if (!$file) {
						continue;
					}
					$ticket->addMedia($file)->toMediaCollection('attachments');
				}
			}

			return $ticket;
		});
	}
}
