<?php

namespace App\Enums;

enum TicketStatus: string
{
	case New = 'new';
	case InProgress = 'in_progress';
	case Resolved = 'resolved';

	public function label(): string
	{
		return match ($this) {
			self::New => __('New'),
			self::InProgress => __('In Progress'),
			self::Resolved => __('Resolved'),
		};
	}

	public static function values(): array
	{
		return array_column(self::cases(), 'value');
	}
}
